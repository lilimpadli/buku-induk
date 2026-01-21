<?php

namespace App\Imports;

use App\Models\NilaiRaport;
use App\Models\Kehadiran;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\RaporInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Throwable;
use Illuminate\Support\Facades\Log;

class LegerImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    protected $semester;
    protected $tahunAjaran;
    protected $rombelId;
    protected $mapelList = [];
    protected $errors = [];
    protected $successCount = 0;
    protected $headerRow = [];
    protected $rowCount = 0;

    public function __construct($rombelId, $semester, $tahunAjaran)
    {
        $this->rombelId = $rombelId;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;

        // Get all mapel sorted by urutan untuk position-based mapping
        $this->mapelList = MataPelajaran::orderBy('urutan')->get();
        
        Log::info('LegerImport initialized', [
            'rombelId' => $rombelId,
            'semester' => $semester,
            'tahunAjaran' => $tahunAjaran,
            'mapelCount' => $this->mapelList->count()
        ]);
    }

    /**
     * Start from row 10 (data rows)
     * Rows 1-3: School header
     * Row 4: Empty (title placeholder)
     * Row 5: Title  
     * Row 6: Empty
     * Rows 7-8: Info (Rombel, Tingkat, Semester, Tahun Ajaran)
     * Row 9: Column headers (NO, NISN, NIS, NAMA SISWA, JENIS KELAMIN, MAPEL1, MAPEL2, ..., SAKIT, IZIN, ALPA)
     * Row 10+: Data rows
     */
    public function startRow(): int
    {
        return 10;
    }

    public function model(array $row)
    {
        $this->rowCount++;
        
        // Skip empty rows
        if (empty($row['0']) && empty($row['1']) && empty($row['2'])) {
            Log::debug("Skipping empty row {$this->rowCount}");
            return null;
        }

        try {
            $nisn = trim($row['1'] ?? '');
            $nis = trim($row['2'] ?? '');
            
            Log::info("Processing row {$this->rowCount}: NIS={$nis}, NISN={$nisn}");

            // Find siswa - coba berbagai kombinasi
            $siswa = DataSiswa::where('nisn', $nisn)
                ->where('nis', $nis)
                ->where('rombel_id', $this->rombelId)
                ->first();

            if (!$siswa && !empty($nisn)) {
                $siswa = DataSiswa::where('nisn', $nisn)
                    ->where('rombel_id', $this->rombelId)
                    ->first();
            }

            if (!$siswa && !empty($nis)) {
                $siswa = DataSiswa::where('nis', $nis)
                    ->where('rombel_id', $this->rombelId)
                    ->first();
            }

            if (!$siswa) {
                $msg = "Siswa NIS={$nis}, NISN={$nisn} tidak ditemukan";
                Log::warning($msg);
                $this->errors[] = $msg;
                return null;
            }

            Log::info("Found siswa: {$siswa->nama_lengkap} (ID: {$siswa->id})");

            $nilaiCount = 0;

            // Process mapel values - start from column index 5 (after NO, NISN, NIS, NAMA, JENIS KELAMIN)
            // Columns: 0=NO, 1=NISN, 2=NIS, 3=NAMA SISWA, 4=JENIS KELAMIN, 5...N=MAPEL, N+1=SAKIT, N+2=IZIN, N+3=ALPA
            $startMapelCol = 5;
            $endMapelCol = 5 + count($this->mapelList) - 1;

            Log::info("Processing mapel columns {$startMapelCol}-{$endMapelCol}", [
                'mapelCount' => count($this->mapelList)
            ]);

            for ($colIdx = $startMapelCol; $colIdx <= $endMapelCol; $colIdx++) {
                $nilaiValue = $row[$colIdx] ?? '';

                if ($nilaiValue === '' || $nilaiValue === null) {
                    continue;
                }

                $nilaiFloat = (float) $nilaiValue;
                if ($nilaiFloat == 0) {
                    continue;
                }

                // Get mapel berdasarkan posisi relative dari start
                $mapelIdx = $colIdx - $startMapelCol;
                $mapel = $this->mapelList[$mapelIdx] ?? null;

                if (!$mapel) {
                    Log::warning("Mapel not found at index {$mapelIdx}");
                    continue;
                }

                Log::debug("Column {$colIdx} -> Mapel {$mapelIdx}: {$mapel->nama} = {$nilaiFloat}");

                if ($nilaiFloat >= 0 && $nilaiFloat <= 100) {
                    try {
                        NilaiRaport::updateOrCreate(
                            [
                                'siswa_id' => $siswa->id,
                                'mata_pelajaran_id' => $mapel->id,
                                'semester' => $this->semester,
                                'tahun_ajaran' => $this->tahunAjaran,
                            ],
                            [
                                'nilai_akhir' => $nilaiFloat,
                                'kelas_id' => $siswa->rombel->kelas_id ?? null,
                                'rombel_id' => $this->rombelId,
                            ]
                        );
                        $nilaiCount++;
                        Log::debug("Created NilaiRaport for {$mapel->nama}");
                    } catch (Throwable $e) {
                        $msg = "Error menyimpan nilai untuk {$siswa->nama_lengkap}: " . $e->getMessage();
                        Log::error($msg);
                        $this->errors[] = $msg;
                    }
                }
            }

            Log::info("Total nilai created for siswa: {$nilaiCount}");

            // Save kehadiran - columns after mapel
            $attendanceStartCol = $endMapelCol + 1;
            $sakit = (int) ($row[$attendanceStartCol] ?? 0);
            $izin = (int) ($row[$attendanceStartCol + 1] ?? 0);
            $alpa = (int) ($row[$attendanceStartCol + 2] ?? 0);

            if ($sakit > 0 || $izin > 0 || $alpa > 0) {
                try {
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
                } catch (Throwable $e) {
                    // Silent
                }
            }

            // Create RaporInfo jika ada nilai
            if ($nilaiCount > 0) {
                try {
                    RaporInfo::updateOrCreate(
                        [
                            'siswa_id' => $siswa->id,
                            'semester' => $this->semester,
                            'tahun_ajaran' => $this->tahunAjaran,
                        ],
                        [
                            'tanggal_rapor' => now()->format('Y-m-d'),
                        ]
                    );
                    $this->successCount++;
                    Log::info("Created RaporInfo - Success count now: {$this->successCount}");
                } catch (Throwable $e) {
                    Log::error("Error creating RaporInfo: " . $e->getMessage());
                }
            } else {
                Log::warning("No nilai created, RaporInfo not created for siswa {$siswa->nama_lengkap}");
            }

            return null;

        } catch (Throwable $e) {
            $msg = "Error processing row {$this->rowCount}: " . $e->getMessage();
            Log::error($msg);
            $this->errors[] = $msg;
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

    public function getSuccessCount()
    {
        return $this->successCount;
    }
}
