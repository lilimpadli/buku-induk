<?php

namespace App\Imports;

use App\Models\NilaiRaport;
use App\Models\Kehadiran;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Throwable;

class LegerImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $semester;
    protected $tahunAjaran;
    protected $rombelId;
    protected $mapelMap = [];
    protected $errors = [];

    public function __construct($rombelId, $semester, $tahunAjaran)
    {
        $this->rombelId = $rombelId;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;

        // Map mapel name to ID
        $mapels = MataPelajaran::all();
        foreach ($mapels as $mapel) {
            $this->mapelMap[strtoupper(substr($mapel->nama, 0, 10))] = $mapel->id;
        }
    }

    public function model(array $row)
    {
        // Skip header rows
        if (empty($row['nisn']) || empty($row['nis'])) {
            return null;
        }

        try {
            // Find siswa by NISN dan NIS
            $siswa = DataSiswa::where('nisn', $row['nisn'])
                ->where('nis', $row['nis'])
                ->where('rombel_id', $this->rombelId)
                ->first();

            if (!$siswa) {
                $this->errors[] = "Siswa dengan NIS {$row['nis']} dan NISN {$row['nisn']} tidak ditemukan di rombel ini";
                return null;
            }

            // Get list of mapel columns
            $mapelColumns = array_keys($row);
            $mapelColumns = array_filter($mapelColumns, function($col) {
                return !in_array(strtolower($col), [
                    'no', 'nisn', 'nis', 'nama_siswa', 'sakit', 'izin', 'alpa', 
                    'no_rec', 'nama', 'jenis_kelamin', 'alamat'
                ]);
            });

            // Insert/update nilai for each mata pelajaran
            foreach ($mapelColumns as $mapelCol) {
                $nilaiValue = $row[$mapelCol] ?? null;

                if ($nilaiValue !== '' && $nilaiValue !== null && $nilaiValue !== 0) {
                    // Get mapel ID
                    $mapelKey = strtoupper(trim($mapelCol));
                    $mapelId = $this->mapelMap[$mapelKey] ?? null;

                    if ($mapelId) {
                        $nilaiFloat = (float) $nilaiValue;
                        
                        // Validasi nilai antara 0-100
                        if ($nilaiFloat >= 0 && $nilaiFloat <= 100) {
                            NilaiRaport::updateOrCreate(
                                [
                                    'siswa_id' => $siswa->id,
                                    'mata_pelajaran_id' => $mapelId,
                                    'semester' => $this->semester,
                                    'tahun_ajaran' => $this->tahunAjaran,
                                ],
                                [
                                    'nilai_akhir' => $nilaiFloat,
                                    'kelas_id' => $siswa->rombel->kelas_id ?? null,
                                    'rombel_id' => $this->rombelId,
                                ]
                            );
                        }
                    }
                }
            }

            // Update/insert kehadiran
            $sakit = (int) ($row['sakit'] ?? 0);
            $izin = (int) ($row['izin'] ?? 0);
            $alpa = (int) ($row['alpa'] ?? 0);

            if ($sakit > 0 || $izin > 0 || $alpa > 0) {
                Kehadiran::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'semester' => $this->semester,
                        'tahun_ajaran' => $this->tahunAjaran,
                    ],
                    [
                        'sakit' => $sakit,
                        'izin' => $izin,
                        'alpa' => $alpa,
                    ]
                );
            }

            return null; // Tidak perlu return model, sudah updated

        } catch (Throwable $e) {
            $this->errors[] = "Error pada baris NISN {$row['nisn']}: " . $e->getMessage();
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
}
