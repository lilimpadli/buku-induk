<?php

namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class NilaiRaportTemplate implements FromArray, WithStyles, WithColumnWidths
{
    protected $rombelIds;
    protected $semester;
    protected $tahunAjaran;

    public function __construct($rombelIds = [], $semester = null, $tahunAjaran = null)
    {
        $this->rombelIds = $rombelIds;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
    }

    public function array(): array
    {
        // Get students
        $siswas = DataSiswa::with('rombel')
            ->whereIn('rombel_id', $this->rombelIds)
            ->orderBy('nama_lengkap')
            ->get();

        if ($siswas->isEmpty()) {
            return [['Tidak ada data siswa']];
        }

        // Get all mata pelajaran, sorted by urutan
        $mapelList = MataPelajaran::orderBy('urutan')->get()->toArray();

        // Build header
        $data = [];

        // School Header
        $data[] = ['PEMERINTAH KOTA KAWALI'];
        $data[] = ['DINAS PENDIDIKAN'];
        $data[] = ['SEKOLAH MENENGAH KEJURUAN NEGERI 1 KAWALI'];
        $data[] = [];

        // Title
        $data[] = ['TEMPLATE INPUT NILAI RAPORT'];
        $data[] = [];

        // Info
        $data[] = ['Semester:', $this->semester ?? 'Semua'];
        $data[] = ['Tahun Ajaran:', $this->tahunAjaran ?? 'Semua'];
        $data[] = ['Instruksi: Isikan nilai siswa pada kolom mata pelajaran. Gunakan angka 0-100.'];
        $data[] = [];

        // Table header row
        $headerRow = ['NO', 'NISN', 'NIS', 'NAMA SISWA'];
        foreach ($mapelList as $mapel) {
            $headerRow[] = strtoupper(substr($mapel['nama'] ?? 'MAPEL', 0, 10));
        }
        $headerRow[] = 'SAKIT';
        $headerRow[] = 'IZIN';
        $headerRow[] = 'ALPA';

        $data[] = $headerRow;

        // Data rows with sample data
        $no = 1;
        foreach ($siswas as $siswa) {
            $row = [$no, $siswa->nisn, $siswa->nis, $siswa->nama_lengkap];

            // Add empty cells for mata pelajaran
            foreach ($mapelList as $mapel) {
                $row[] = ''; // Kosong untuk diisi user
            }

            // Add empty cells for kehadiran
            $row[] = '0'; // Sakit
            $row[] = '0'; // Izin
            $row[] = '0'; // Alpa

            $data[] = $row;
            $no++;
        }

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 12,
            'D' => 25,
            'E' => 8,
            'F' => 8,
            'G' => 8,
            'H' => 8,
            'I' => 8,
            'J' => 8,
            'K' => 8,
            'L' => 8,
            'M' => 8,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set column heights
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(18);
        $sheet->getRowDimension(3)->setRowHeight(18);
        $sheet->getRowDimension(4)->setRowHeight(5);
        $sheet->getRowDimension(5)->setRowHeight(22);
        $sheet->getRowDimension(6)->setRowHeight(5);

        // ===== SCHOOL HEADER (Rows 1-3) =====
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '1F2937'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '374151'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A3:E3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '1F2937'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // ===== TITLE (Row 5) =====
        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '1F2937'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // ===== INFO ROWS (Rows 7-10) =====
        $sheet->getStyle('A7:B10')->applyFromArray([
            'font' => [
                'size' => 11,
                'color' => ['rgb' => '374151'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Make labels bold
        $sheet->getStyle('A7')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F2937']],
        ]);
        $sheet->getStyle('A8')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F2937']],
        ]);
        $sheet->getStyle('A9')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F2937']],
        ]);

        // ===== TABLE HEADER (Row 12) =====
        $headerRow = 12;
        $lastColumn = 'M';
        $headerRange = 'A' . $headerRow . ':' . $lastColumn . $headerRow;

        $sheet->getStyle($headerRange)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '1E40AF'],  // Darker blue
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '1E40AF'],
                ],
            ],
        ]);

        $sheet->getRowDimension($headerRow)->setRowHeight(28);

        // ===== DATA ROWS =====
        $dataStartRow = $headerRow + 1;
        $dataEndRow = $sheet->getHighestRow();

        if ($dataStartRow <= $dataEndRow) {
            // All data cells - borders
            $sheet->getStyle('A' . $dataStartRow . ':' . $lastColumn . $dataEndRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D1D5DB'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size' => 10,
                    'color' => ['rgb' => '1F2937'],
                ],
            ]);

            // Align text columns to left (NIS, NISN, Nama Siswa)
            $sheet->getStyle('B' . $dataStartRow . ':D' . $dataEndRow)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alternate row background colors
            for ($row = $dataStartRow; $row <= $dataEndRow; $row++) {
                if (($row - $dataStartRow) % 2 == 0) {
                    // Even rows - light background
                    $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => 'F9FAFB'],
                        ],
                    ]);
                }
            }

            // Set row height for data rows
            for ($row = $dataStartRow; $row <= $dataEndRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(22);
            }
        }

        // ===== FREEZING PANES =====
        $sheet->freezePane('A13');  // Freeze header row

        // ===== PRINT SETTINGS =====
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // Set print area to auto-fit
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getPageSetup()->setFitToWidth(1);

        // Set margins
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setBottom(0.75);

        return [];
    }
}
