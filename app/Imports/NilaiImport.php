<?php

namespace App\Imports;

use App\Models\NilaiRaport;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;
use Throwable;

class NilaiImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError, WithChunkReading
{
    protected $defaultSemester;
    protected $defaultTahunAjaran;
    protected $mapelMap = [];
    protected $errors = [];
    protected $successCount = 0;
    protected $processedRows = 0;
    protected $rowCount = 0;
    protected $skippedEmptyRows = 0;

    public function __construct($semester, $tahunAjaran)
    {
        $this->defaultSemester = $semester;
        $this->defaultTahunAjaran = $tahunAjaran;

        $mapels = MataPelajaran::all();
        foreach ($mapels as $mapel) {
            $this->mapelMap[strtolower(trim($mapel->nama))] = $mapel->id;
        }
    }

    public function model(array $row)
    {
        $this->rowCount++;
        $this->processedRows++;

        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedRow[strtolower(trim($key))] = $value;
        }
        $row = $normalizedRow;

        $nis = isset($row['nis']) ? trim((string) $row['nis']) : null;
        $nisn = isset($row['nisn']) ? trim((string) $row['nisn']) : null;

        if (empty($nis) || empty($nisn)) {
            $this->skippedEmptyRows++;
            return null;
        }

        $semester = isset($row['semester']) ? trim((string) $row['semester']) : $this->defaultSemester;
        $semesterLower = strtolower($semester);
        if ($semesterLower === 'ganjil' || $semesterLower === '1') {
            $semester = 'Ganjil';
        } elseif ($semesterLower === 'genap' || $semesterLower === '2') {
            $semester = 'Genap';
        }

        $tahunAjaran = isset($row['tahun_ajaran']) ? trim((string) $row['tahun_ajaran']) : $this->defaultTahunAjaran;

        try {
            $siswa = DataSiswa::where('nis', $nis)->where('nisn', $nisn)->first();

            if (!$siswa) {
                $this->errors[] = "Siswa dengan NIS {$nis} dan NISN {$nisn} tidak ditemukan (baris {$this->rowCount})";
                return null;
            }

            $headers = array_keys($row);
            $excludeColumns = ['no', 'nis', 'nisn', 'nama_siswa', 'rombel', 'semester', 'tahun_ajaran'];

            foreach ($headers as $col) {
                $colLower = strtolower(trim($col));
                if (in_array($colLower, $excludeColumns)) {
                    continue;
                }

                $nilaiValue = $row[$col] ?? null;
                if ($nilaiValue === '' || $nilaiValue === null) {
                    continue;
                }

                $mapelId = $this->mapelMap[$colLower] ?? null;
                if (!$mapelId) {
                    continue;
                }

                $existing = NilaiRaport::where([
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mapelId,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ])->first();

                if ($existing) {
                    $existing->nilai_akhir = (float) $nilaiValue;
                    $existing->kelas_id = $siswa->rombel->kelas_id ?? null;
                    $existing->rombel_id = $siswa->rombel_id;
                    $existing->save();
                } else {
                    NilaiRaport::create([
                        'siswa_id' => $siswa->id,
                        'mata_pelajaran_id' => $mapelId,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran,
                        'nilai_akhir' => (float) $nilaiValue,
                        'kelas_id' => $siswa->rombel->kelas_id ?? null,
                        'rombel_id' => $siswa->rombel_id,
                    ]);
                }
                $this->successCount++;
            }

            return null;

        } catch (Throwable $e) {
            $this->errors[] = "Error pada baris {$this->rowCount} (NIS {$nis}): " . $e->getMessage();
            Log::error("NilaiImport Error: " . $e->getMessage());
            return null;
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function onError(\Throwable $e)
    {
        Log::error('NilaiImport Error: ' . $e->getMessage());
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getProcessedRows()
    {
        return $this->processedRows;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSkippedEmptyRows()
    {
        return $this->skippedEmptyRows;
    }
}   