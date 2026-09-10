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
        'nik' => 'NIK',
        'nuptk' => 'NUPTK',
        'nip' => 'NIP',
        'status_kepegawaian' => 'Status Kepegawaian',
        'jenis_kelamin' => 'Jenis Kelamin',
        'pendidikan' => 'Pendidikan',
        'serdik' => 'Serdik',
        'tugas_tambahan' => 'Tugas Tambahan',   // ← TAMBAHAN
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'email_pribadi' => 'Email Pribadi',
        'email_resmi' => 'Email Resmi',
        'alamat' => 'Alamat',
        'rt' => 'RT',
        'rw' => 'RW',
        'dusun' => 'Dusun',
        'kelurahan' => 'Kelurahan',
        'kecamatan' => 'Kecamatan',
        'kode_pos' => 'Kode Pos',
        'no_hp' => 'No HP',
    ];

    protected static $fieldWidths = [
        'nama' => 30,
        'nik' => 25,
        'nuptk' => 25,
        'nip' => 25,
        'status_kepegawaian' => 30,
        'jenis_kelamin' => 18,
        'pendidikan' => 18,
        'serdik' => 20,
        'tugas_tambahan' => 30,                 // ← TAMBAHAN
        'tempat_lahir' => 22,
        'tanggal_lahir' => 20,
        'email_pribadi' => 30,
        'email_resmi' => 30,
        'alamat' => 35,
        'rt' => 12,
        'rw' => 12,
        'dusun' => 20,
        'kelurahan' => 25,
        'kecamatan' => 25,
        'kode_pos' => 15,
        'no_hp' => 20,
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