<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class KelasImportTemplate implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'X',
                'RPL',
                'X RPL 1',
                '1',
                '198402222009011005'
            ],
            [
                'XI',
                'RPL',
                'XI RPL 1',
                '1',
                '197105311995021001'
            ],
            [
                'XII',
                'RPL',
                'XII RPL 1',
                '1',
                ''
            ],
            [
                'X',
                'AK',
                'X AK 1',
                '2',
                ''
            ],
            [
                'X',
                'TJKT',
                'X TJKT 1',
                '3',
                ''
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Tingkat (X/XI/XII)',
            'Jurusan (Kode)',
            'Nama Rombel',
            'Konsentrasi Keahlian (ID)',
            'Wali Kelas (NIP)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1E293B']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DBEAFE']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);

        // Tambahkan catatan di bawah
        $sheet->setCellValue('A7', '📌 Keterangan:');
        $sheet->setCellValue('A8', '1. Tingkat: X, XI, XII');
        $sheet->setCellValue('A9', '2. Jurusan (Kode): RPL, AK, TJKT, TKRO, DPIB, SP, GIM, MP');
        $sheet->setCellValue('A10', '3. Nama Rombel: Format [Tingkat] [Jurusan] [Nomor] (contoh: X RPL 1)');
        $sheet->setCellValue('A11', '4. Konsentrasi Keahlian (ID): Kosongkan jika tidak ada');
        $sheet->setCellValue('A12', '5. Wali Kelas (NIP): Kosongkan jika belum ada');
        
        $sheet->getStyle('A7:A12')->getFont()->setSize(10)->setItalic(true);
        $sheet->getStyle('A7:A12')->getFont()->getColor()->setRGB('64748B');

        // Set lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);

        return [];
    }
}