<?php

namespace App\Exports;

use App\Models\NilaiRaport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NilaiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return NilaiRaport::with(['siswa', 'mapel'])
            ->orderBy('siswa_id')
            ->get()
            ->map(function ($item) {
                return [
                    'siswa_id' => $item->siswa_id,
                    'nis' => $item->siswa->nis ?? '',
                    'nisn' => $item->siswa->nisn ?? '',
                    'nama_lengkap' => $item->siswa->nama_lengkap ?? '',
                    'mata_pelajaran' => $item->mapel->nama ?? '',
                    'tahun_ajaran' => $item->tahun_ajaran,
                    'semester' => $item->semester,
                    'nilai' => $item->nilai_akhir,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'siswa_id',
            'nis',
            'nisn',
            'nama_lengkap',
            'mata_pelajaran',
            'tahun_ajaran',
            'semester',
            'nilai',
        ];
    }
}
