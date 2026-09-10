<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ClaverExport implements FromArray, WithStyles, WithTitle
{
    protected $data;
    protected $tahunAjaran;
    
    // Properti untuk menyimpan koordinat baris agar styling mudah
    protected $hurufRows = [];
    protected $tableHeaders = [];
    protected $dataRows = [];

    public function __construct($data, $tahunAjaran = '2024/2025')
    {
        $this->data = $data;
        $this->tahunAjaran = $tahunAjaran;
    }

    /**
     * Judul Sheet
     */
    public function title(): string
    {
        return 'CLAVER';
    }

    /**
     * Data yang akan diexport
     */
    public function array(): array
    {
        $rows = [];
        
        // Baris 1: Judul Utama
        $rows[] = ['BUKU INDUK SISWA (CLAVER)', '', '', '', '', '', '', ''];
        // Baris 2: Sub Judul
        $rows[] = ['TAHUN PELAJARAN ' . $this->tahunAjaran, '', '', '', '', '', '', ''];
        // Baris 3: Baris Kosong
        $rows[] = ['', '', '', '', '', '', '', ''];

        // Looping Per Huruf
        foreach ($this->data as $huruf => $siswas) {
            // Catat baris untuk Header Huruf
            $this->hurufRows[] = count($rows) + 1;
            $rows[] = ["HURUF {$huruf}", '', '', '', '', '', '', ''];

            // Catat baris untuk Header Tabel 1
            $h1 = count($rows) + 1;
            $rows[] = ['NO', 'NAMA SISWA', 'NOMOR INDUK SISWA', 'TANGGAL', '', '', '', 'KET'];
            
            // Catat baris untuk Header Tabel 2
            $h2 = count($rows) + 1;
            $rows[] = ['', '', '', 'MULAI MASUK', 'NAIK KELAS 1', 'NAIK KELAS 2', 'NAIK KELAS 3', ''];
            
            $this->tableHeaders[] = ['h1' => $h1, 'h2' => $h2];

            // Data Siswa
            $no = 1;
            foreach ($siswas as $siswa) {
                $this->dataRows[] = count($rows) + 1;
                $rows[] = [
                    $no++,
                    $siswa['nama_siswa'] ?? '-',
                    $siswa['nomor_induk'] ?? '-',
                    $siswa['tanggal_masuk'] ?? '-',
                    $siswa['naik_kelas_1'] ?? '-',
                    $siswa['naik_kelas_2'] ?? '-',
                    $siswa['naik_kelas_3'] ?? '-',
                    $siswa['keterangan'] ?? '-',
                ];
            }

            // Baris kosong antar huruf
            $rows[] = ['', '', '', '', '', '', '', ''];
        }

        return $rows;
    }

    /**
     * Style untuk Excel - Layout sesuai gambar referensi
     */
    public function styles(Worksheet $sheet)
    {
        // ============================================================
        // 1. JUDUL UTAMA
        // ============================================================
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // ============================================================
        // 2. SUB JUDUL
        // ============================================================
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // ============================================================
        // 3. STYLE HURUF (HURUF A, HURUF B, dst)
        // ============================================================
        foreach ($this->hurufRows as $row) {
            $sheet->mergeCells('A' . $row . ':H' . $row);
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'name' => 'Times New Roman',
                    'color' => ['rgb' => '1E40AF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E0E7FF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        // ============================================================
        // 4. STYLE HEADER TABEL (NO - KET)
        // ============================================================
        foreach ($this->tableHeaders as $headers) {
            $h1 = $headers['h1'];
            $h2 = $headers['h2'];

            // --- MERGE CELLS SESUAI FOTO REFERENSI ---
            $sheet->mergeCells('A' . $h1 . ':A' . $h2); // NO
            $sheet->mergeCells('B' . $h1 . ':B' . $h2); // NAMA SISWA
            $sheet->mergeCells('C' . $h1 . ':C' . $h2); // NOMOR INDUK SISWA
            $sheet->mergeCells('D' . $h1 . ':G' . $h1); // TANGGAL (Merge 4 kolom: D sampai G)
            $sheet->mergeCells('H' . $h1 . ':H' . $h2); // KET

            // --- STYLE HEADER TABEL ---
            $sheet->getStyle('A' . $h1 . ':H' . $h2)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 9,
                    'name' => 'Times New Roman',
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
        }

        // ============================================================
        // 5. STYLE DATA SISWA
        // ============================================================
        foreach ($this->dataRows as $row) {
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'font' => [
                    'size' => 10,
                    'name' => 'Times New Roman',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Kolom NO (A) - center
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Kolom NAMA SISWA (B) - Left
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Kolom NIS (C) - center
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Kolom Tanggal (D-G) & KET (H) - center
            $sheet->getStyle('D' . $row . ':H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // ============================================================
        // 6. SET LEBAR KOLOM (Meniru gambar referensi)
        // ============================================================
        $sheet->getColumnDimension('A')->setWidth(5);   // NO
        $sheet->getColumnDimension('B')->setWidth(30);  // NAMA SISWA
        $sheet->getColumnDimension('C')->setWidth(20);  // NOMOR INDUK SISWA
        $sheet->getColumnDimension('D')->setWidth(14);  // MULAI MASUK
        $sheet->getColumnDimension('E')->setWidth(14);  // NAIK KELAS 1
        $sheet->getColumnDimension('F')->setWidth(14);  // NAIK KELAS 2
        $sheet->getColumnDimension('G')->setWidth(14);  // NAIK KELAS 3
        $sheet->getColumnDimension('H')->setWidth(10);  // KET

        // ============================================================
        // 7. SET ORIENTASI PRINT A4 LANDSCAPE
        // ============================================================
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // Set margin
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
    }
}