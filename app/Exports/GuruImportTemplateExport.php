<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GuruImportTemplateExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    public function array(): array
    {
        return [
            [
                'Abdullah',
                '198201030221006',
                'L',
                'abdullah@smkn1x.sch.id',
                'walikelas',
                '1',
                '',
            ],
            [
                'Abu Bakar',
                '198205102231008',
                'L',
                '',
                'guru',
                '',
                '2',
            ],
            [
                'Achmad Salam',
                '198206030331009',
                'L',
                'achmad@smkn1x.sch.id',
                'kaprog',
                '',
                '1',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'nomor_induk',
            'jenis_kelamin',
            'email',
            'role',
            'rombel_id',
            'jurusan_id',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
            'D' => 30,
            'E' => 15,
            'F' => 12,
            'G' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '2F53FF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        // Set row height for header
        $sheet->getRowDimension('1')->setRowHeight(25);

        // Center align data
        $sheet->getStyle('A2:G' . (count($this->array()) + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Add note in column below data
        $lastRow = count($this->array()) + 1;
        $sheet->getCell('A' . ($lastRow + 2))->setValue('Catatan:');
        $sheet->getStyle('A' . ($lastRow + 2))->getFont()->setBold(true);

        $notes = [
            '- nama: Nama lengkap guru (wajib)',
            '- nomor_induk (atau nip): Nomor induk/NIP guru (wajib)',
            '- jenis_kelamin: L atau P',
            '- email: Opsional, akan auto-generate jika kosong',
            '- role: guru, walikelas, kaprog, tu, kurikulum',
            '- rombel_id: ID rombel untuk wali kelas',
            '- jurusan_id: ID jurusan untuk kaprog',
            '',
            'Password default: 12345678',
        ];

        foreach ($notes as $index => $note) {
            $sheet->getCell('A' . ($lastRow + 3 + $index))->setValue($note);
            $sheet->getStyle('A' . ($lastRow + 3 + $index))->getFont()->setSize(10);
        }

        // Freeze first row
        $sheet->freezePane('A2');

        return [];
    }
}
