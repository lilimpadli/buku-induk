<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PklIjazahExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return Siswa::with('rombel.kelas')
            ->whereHas('rombel.kelas', function ($query) {
                $query->where('tingkat', 'XII');
            })
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($siswa) {
                return [
                    'kelas' => optional($siswa->rombel->kelas)->tingkat ?? '',
                    'rombel' => $siswa->rombel->nama ?? '',
                    'nis' => $siswa->nis ?? '',
                    'nisn' => $siswa->nisn ?? '',
                    'nama_lengkap' => $siswa->nama_lengkap ?? '',
                    'pkl_nilai' => $siswa->pkl_nilai ?? '',
                    'pkl_sertifikat' => $siswa->pkl_sertifikat ?? '',
                    'pkl_nama_industri' => $siswa->pkl_nama_industri ?? '',
                    'pkl_alamat' => $siswa->pkl_alamat ?? '',
                    'ijazah_nomor' => $siswa->ijazah_nomor ?? '',
                    'ijazah_tanggal' => $siswa->ijazah_tanggal ? \Carbon\Carbon::parse($siswa->ijazah_tanggal)->format('Y-m-d') : '',
                    'transkip_nomor' => $siswa->transkip_nomor ?? '',
                    'transkip_tanggal' => $siswa->transkip_tanggal ? \Carbon\Carbon::parse($siswa->transkip_tanggal)->format('Y-m-d') : '',
                    'tanggal_lulus' => $siswa->tanggal_lulus ? \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('Y-m-d') : '',
                    'status_kelulusan' => $siswa->status_kelulusan ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'kelas',
            'rombel',
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFDDDDDD');

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
