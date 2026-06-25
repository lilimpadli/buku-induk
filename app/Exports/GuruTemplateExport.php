<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GuruTemplateExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    protected static $fieldLabels = [
        'nama' => 'Nama',
        'nip' => 'NIP',
        'status_kepegawaian' => 'Status Kepegawaian',
        'pendidikan' => 'Pendidikan',
        'gelar_depan' => 'Gelar Depan',
        'gelar_belakang' => 'Gelar Belakang',
    ];

    protected static $fieldWidths = [
        'nama' => 30,
        'nip' => 25,
        'status_kepegawaian' => 30,
        'pendidikan' => 18,
        'gelar_depan' => 20,
        'gelar_belakang' => 20,
    ];

    protected array $fields;

    public function __construct(?array $fields = null)
    {
        $this->fields = $fields ?: array_keys(self::$fieldLabels);
        if (empty($this->fields)) {
            $this->fields = array_keys(self::$fieldLabels);
        }
    }

    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return array_values(array_intersect_key(self::$fieldLabels, array_flip($this->fields)));
    }

    public function columnWidths(): array
    {
        $widths = [];
        foreach ($this->fields as $index => $field) {
            $columnLetter = Coordinate::stringFromColumnIndex($index + 1);
            $widths[$columnLetter] = self::$fieldWidths[$field] ?? 20;
        }
        return $widths;
    }

    public function styles(Worksheet $sheet)
    {
        $totalColumns = count($this->fields);
        $lastColumn = Coordinate::stringFromColumnIndex($totalColumns);
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->freezePane('A2');

        return [];
    }
}
