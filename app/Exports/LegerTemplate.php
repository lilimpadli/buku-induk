<?php

namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\Rombel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LegerTemplate implements FromArray, WithStyles, WithColumnWidths
{
    protected $rombelId;
    protected $semester;
    protected $tahunAjaran;

    public function __construct($rombelId, $semester = null, $tahunAjaran = null)
    {
        $this->rombelId = $rombelId;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
    }

    public function array(): array
    {
        // Get rombel info
        $rombel = Rombel::find($this->rombelId);
        if (!$rombel) {
            return [['Data rombel tidak ditemukan']];
        }

        // Get students in this rombel
        $siswas = DataSiswa::with('rombel')
            ->where('rombel_id', $this->rombelId)
            ->orderBy('nama_lengkap')
            ->get();

        if ($siswas->isEmpty()) {
            return [['Tidak ada data siswa di rombel ini']];
        }

        // Get kelas info untuk filter mata pelajaran
        $kelas = $rombel->kelas;
        $tingkat = $kelas ? (string) $kelas->tingkat : null;
        $jurusanId = $kelas ? $kelas->jurusan_id : null;

        // Filter mata pelajaran berdasarkan tingkat dan jurusan
        $mapelQuery = MataPelajaran::orderBy('urutan');

        if ($tingkat) {
            // Convert tingkat to various formats
            $toInt = function($t) {
                $map = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8,'IX'=>9,'X'=>10,'XI'=>11,'XII'=>12];
                $tUp = strtoupper(trim($t));
                if (is_numeric($tUp)) return (int)$tUp;
                if (isset($map[$tUp])) return $map[$tUp];
                return null;
            };

            $opts = [$tingkat];
            $cur = $toInt($tingkat);
            if ($cur !== null) {
                $opts[] = (string) $cur;
            }
            $opts = array_values(array_unique(array_filter($opts)));

            // Filter by tingkat
            $mapelQuery = $mapelQuery->whereHas('tingkats', function($q) use ($opts) {
                $q->whereIn('tingkat', $opts);
            });
        }

        // Filter by jurusan: include global (jurusan_id NULL) and subjects for the kelas's jurusan
        if ($jurusanId) {
            $mapelQuery = $mapelQuery->where(function($q) use ($jurusanId) {
                $q->whereNull('jurusan_id')->orWhere('jurusan_id', $jurusanId);
            });
        }

        $mapelList = $mapelQuery->get()->toArray();

        // Build header
        $data = [];

        // School Header
        $data[] = ['PEMERINTAH KOTA KAWALI'];
        $data[] = ['DINAS PENDIDIKAN'];
        $data[] = ['SEKOLAH MENENGAH KEJURUAN NEGERI 1 KAWALI'];
        $data[] = [];

        // Title
        $data[] = ['LEGER NILAI SISWA'];
        $data[] = [];

        // Info Rombel
        $data[] = ['Rombel:', $rombel->nama ?? ''];
        $data[] = ['Tingkat:', $rombel->kelas->tingkat ?? ''];
        $data[] = ['Semester:', $this->semester ?? 'Semua'];
        $data[] = ['Tahun Ajaran:', $this->tahunAjaran ?? 'Semua'];
        $data[] = [];

        // Table header row
        $headerRow = ['NO', 'NISN', 'NIS', 'NAMA SISWA', 'JENIS KELAMIN'];
        
        // Add mata pelajaran columns
        foreach ($mapelList as $mapel) {
            $headerRow[] = strtoupper(substr($mapel['nama'] ?? 'MAPEL', 0, 12));
        }
        
        // Add attendance columns
        $headerRow[] = 'SAKIT';
        $headerRow[] = 'IZIN';
        $headerRow[] = 'ALPA';

        $data[] = $headerRow;

        // Data rows
        $no = 1;
        foreach ($siswas as $siswa) {
            $row = [
                $no,
                $siswa->nisn,
                $siswa->nis,
                $siswa->nama_lengkap,
                $siswa->jenis_kelamin ?? '-'
            ];

            // Add empty cells for mata pelajaran (values will be filled by user)
            foreach ($mapelList as $mapel) {
                $row[] = '';
            }

            // Add default attendance values
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
        $widths = [
            'A' => 5,      // NO
            'B' => 12,     // NISN
            'C' => 12,     // NIS
            'D' => 25,     // NAMA SISWA
            'E' => 15,     // JENIS KELAMIN
        ];

        // Add widths for mata pelajaran (starting from F)
        $letterIndex = 70; // ASCII for 'F'
        for ($i = 0; $i < 15; $i++) {
            $widths[chr($letterIndex + $i)] = 10;
        }

        // Add widths for attendance columns
        $baseLetterIndex = 70 + 15;
        $widths[chr($baseLetterIndex)] = 10;     // SAKIT
        $widths[chr($baseLetterIndex + 1)] = 10; // IZIN
        $widths[chr($baseLetterIndex + 2)] = 10; // ALPA

        return $widths;
    }

    public function styles(Worksheet $sheet)
    {
        // School header styling
        $sheet->getStyle('A1:A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(18);
        $sheet->getRowDimension(2)->setRowHeight(18);
        $sheet->getRowDimension(3)->setRowHeight(18);

        // Title styling
        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Info rows styling
        $sheet->getStyle('A7:B10')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        // Find header row (based on structure)
        $headerRow = 12;

        // Header styling with blue background
        $lastColumn = chr(70 + count($this->array()[0]) - 1);
        $headerRange = 'A' . $headerRow . ':' . $lastColumn . $headerRow;
        
        $sheet->getStyle($headerRange)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '0066CC'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
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

        $sheet->getRowDimension($headerRow)->setRowHeight(30);

        // Data rows styling
        $dataStartRow = $headerRow + 1;
        $dataEndRow = $sheet->getHighestRow();

        if ($dataStartRow <= $dataEndRow) {
            $sheet->getStyle('A' . $dataStartRow . ':' . $lastColumn . $dataEndRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Align text columns to left
            $sheet->getStyle('D' . $dataStartRow . ':E' . $dataEndRow)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }

        // Set print settings
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        return [];
    }
}
