<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KelasImportTemplate implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    public function array(): array
    {
        return [
            [
                'Tingkat' => 'X',
                'Jurusan' => 'IPA',
                'Nama Rombel' => 'X IPA 1',
            ],
            [
                'Tingkat' => 'XI',
                'Jurusan' => 'IPS',
                'Nama Rombel' => 'XI IPS 2',
            ],
        ];
    }

    public function headings(): array
    {
        return ['Tingkat', 'Jurusan', 'Nama Rombel'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:C1')->getFont()->setBold(true);
                $sheet->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEEF2FF');
                $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:C' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->freezePane('A2');
            },
        ];
    }
}
