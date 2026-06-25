<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
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
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'dusun',
            'kelurahan',
            'kecamatan',
            'rt',
            'rw',
            'kode_pos',
            'rombel_id',
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
