<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\NilaiRaport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class NilaiImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected array $errors = [];
    protected array $mapelLookup = [];

    public function __construct()
    {
        MataPelajaran::all()->each(function ($mapel) {
            $this->mapelLookup[strtolower(trim($mapel->nama))] = $mapel->id;
            $this->mapelLookup[strtolower(trim($mapel->id))] = $mapel->id;
        });
    }

    public function model(array $row)
    {
        if (empty($row['nis']) || empty($row['nisn']) || empty($row['mata_pelajaran'])) {
            return null;
        }

        $nis = trim((string) $row['nis']);
        $nisn = trim((string) $row['nisn']);
        $mapelKey = strtolower(trim((string) $row['mata_pelajaran']));
        $nilai = $row['nilai'] ?? null;
        $semester = trim((string) ($row['semester'] ?? ''));
        $tahunAjaran = trim((string) ($row['tahun_ajaran'] ?? ''));

        $siswa = Siswa::where('nis', $nis)
            ->where('nisn', $nisn)
            ->first();

        if (!$siswa) {
            $this->errors[] = "Baris dengan NIS {$nis} dan NISN {$nisn} tidak ditemukan.";
            return null;
        }

        $mapelId = $this->mapelLookup[$mapelKey] ?? null;
        if (!$mapelId) {
            $this->errors[] = "Mata pelajaran '{$row['mata_pelajaran']}' tidak dikenali untuk siswa {$siswa->nama_lengkap}.";
            return null;
        }

        $nilaiValue = is_numeric($nilai) ? (float) $nilai : null;
        if ($nilaiValue === null) {
            $this->errors[] = "Nilai tidak valid untuk siswa {$siswa->nama_lengkap} pada mata pelajaran {$row['mata_pelajaran']}.";
            return null;
        }

        $siswa->loadMissing('rombel');

        NilaiRaport::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'mata_pelajaran_id' => $mapelId,
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ],
            [
                'nilai_akhir' => $nilaiValue,
                'kelas_id' => $siswa->rombel->kelas_id ?? null,
                'rombel_id' => $siswa->rombel_id,
            ]
        );

        return null;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
