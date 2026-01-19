<?php

namespace App\Imports;

use App\Models\NilaiRaport;
use App\Models\Kehadiran;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class NilaiRaportImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $semester;
    protected $tahunAjaran;
    protected $mapelMap = [];
    protected $errors = [];

    public function __construct($semester, $tahunAjaran)
    {
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
        // Skip header rows (bagian info di atas tabel sebenarnya)
        if (empty($row['nisn']) || empty($row['nis'])) {
            return null;
        }

        try {
            // Find siswa by NISN dan NIS
            $siswa = DataSiswa::where('nisn', $row['nisn'])
                ->where('nis', $row['nis'])
                ->first();

            if (!$siswa) {
                $this->errors[] = "Siswa dengan NIS {$row['nis']} dan NISN {$row['nisn']} tidak ditemukan";
                return null;
            }

            // Get list of mapel columns (semua kolom kecuali NO, NISN, NIS, NAMA SISWA, SAKIT, IZIN, ALPA)
            $mapelColumns = array_keys($row);
            $mapelColumns = array_filter($mapelColumns, function($col) {
                return !in_array(strtolower($col), ['no', 'nisn', 'nis', 'nama_siswa', 'sakit', 'izin', 'alpa', 'no_rec']);
            });

            // Insert/update nilai for each mata pelajaran
            foreach ($mapelColumns as $mapelCol) {
                $nilaiValue = $row[$mapelCol] ?? null;

                if ($nilaiValue !== '' && $nilaiValue !== null) {
                    // Get mapel ID
                    $mapelId = $this->mapelMap[strtoupper($mapelCol)] ?? null;

                    if ($mapelId) {
                        NilaiRaport::updateOrCreate(
                            [
                                'siswa_id' => $siswa->id,
                                'mata_pelajaran_id' => $mapelId,
                                'semester' => $this->semester,
                                'tahun_ajaran' => $this->tahunAjaran,
                            ],
                            [
                                'nilai_akhir' => (float) $nilaiValue,
                                'kelas_id' => $siswa->rombel->kelas_id ?? null,
                                'rombel_id' => $siswa->rombel_id,
                            ]
                        );
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

            return null; // Return null karena kita tidak return model saat ini
        } catch (Throwable $e) {
            $this->errors[] = "Error pada baris dengan NIS {$row['nis']}: " . $e->getMessage();
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
