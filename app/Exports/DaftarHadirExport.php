<?php

namespace App\Exports;

use App\Models\Rombel;
use App\Models\DataSiswa;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class DaftarHadirExport implements FromView, WithStyles, WithProperties, WithColumnWidths
{
    protected $rombelId;
    protected $bulan;

    public function __construct($rombelId, $bulan)
    {
        $this->rombelId = $rombelId;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $rombel = Rombel::with(['konsentrasiKeahlian'])->findOrFail($this->rombelId);

        $siswa = DataSiswa::where('rombel_id', $this->rombelId)
            ->with('absensi')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        $jumlahLaki = $siswa->filter(function($s) {
            $jk = strtolower($s->jenis_kelamin ?? '');
            return in_array($jk, ['l', 'laki', 'laki-laki']);
        })->count();

        $jumlahPerempuan = $siswa->filter(function($s) {
            $jk = strtolower($s->jenis_kelamin ?? '');
            return in_array($jk, ['p', 'perempuan']);
        })->count();

        $semester = Semester::with('tahunAjaran')->where('is_active', true)->first();
        if (!$semester) {
            $semester = Semester::with('tahunAjaran')->orderBy('id', 'desc')->first();
        }
        $tahunAjaran = optional($semester)->tahunAjaran;

        return view('exports.daftar-hadir-excel', [
            'rombel' => $rombel,
            'siswa' => $siswa,
            'jumlahLaki' => $jumlahLaki,
            'jumlahPerempuan' => $jumlahPerempuan,
            'semester' => $semester,
            'tahunAjaran' => $tahunAjaran,
            'bulan' => $this->bulan,
        ]);
    }

    public function properties(): array
    {
        return [
            'creator' => 'SMK Negeri 1 Kawali',
            'title' => 'Daftar Hadir Siswa',
            'company' => 'SMK Negeri 1 Kawali',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // Urt
            'B' => 15,  // NISN
            'C' => 12,  // NIS
            'D' => 30,  // NAMA
            'E' => 5,   // JK
            'F' => 7,   // Tanggal 1
            'G' => 7,   // Tanggal 2
            'H' => 7,   // Tanggal 3
            'I' => 7,   // Tanggal 4
            'J' => 7,   // Tanggal 5
            'K' => 7,   // Tanggal 6
            'L' => 7,   // Tanggal 7
            'M' => 7,   // Tanggal 8
            'N' => 6,   // S
            'O' => 6,   // I
            'P' => 6,   // A
            'Q' => 10,  // % Kehadiran
            'R' => 15,  // KET
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        $sheet->getPageMargins()->setTop(0.39);
        $sheet->getPageMargins()->setRight(0.39);
        $sheet->getPageMargins()->setLeft(0.39);
        $sheet->getPageMargins()->setBottom(0.39);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:R' . $highestRow)->getFont()->setName('Times New Roman')->setSize(9);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $sheet->getStyle('A1:R' . $highestRow)->applyFromArray($styleArray);

        $sheet->getStyle('A1:R' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D1:D' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('A1:R7')->getFont()->setBold(true);

        $sheet->getRowDimension(1)->setRowHeight(22);
        $sheet->getRowDimension(2)->setRowHeight(16);
        $sheet->getRowDimension(3)->setRowHeight(16);
        $sheet->getRowDimension(4)->setRowHeight(24);
        $sheet->getRowDimension(5)->setRowHeight(16);
        $sheet->getRowDimension(6)->setRowHeight(16);
        $sheet->getRowDimension(7)->setRowHeight(18);

        $sheet->mergeCells('A1:C3');
        $sheet->mergeCells('D1:R1');
        $sheet->mergeCells('D2:R2');
        $sheet->mergeCells('D3:R3');
        $sheet->mergeCells('A4:R4');

        $sheet->mergeCells('A5:C5');
        $sheet->mergeCells('D5:I5');
        $sheet->mergeCells('J5:L5');
        $sheet->mergeCells('M5:R5');

        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('D6:I6');
        $sheet->mergeCells('J6:L6');
        $sheet->mergeCells('M6:R6');

        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('F7:M7');
        $sheet->mergeCells('N7:P7');

        $lastRow = $sheet->getHighestRow();
        if ($lastRow >= 8) {
            for ($row = $lastRow; $row >= 8; $row--) {
                $value = $sheet->getCell('A' . $row)->getValue();
                if ($value == 'JUMLAH') {
                    $sheet->mergeCells('A' . $row . ':D' . $row);
                    $sheet->mergeCells('F' . $row . ':R' . $row);
                    break;
                }
            }
        }

        $sheet->setShowGridlines(false);
        $sheet->setPrintGridlines(false);

        return [];
    }
}