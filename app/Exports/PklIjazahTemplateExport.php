<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PklIjazahTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'nis',
            'nisn',
            'nama_lengkap',
            'pkl_nilai',
            'pkl_sertifikat',
            'pkl_nama_industri',
            'pkl_alamat',
            'ijazah_nomor',
            'ijazah_tanggal',
            'transkip_nomor',
            'transkip_tanggal',
            'tanggal_lulus',
            'status_kelulusan',
        ];
    }
}
