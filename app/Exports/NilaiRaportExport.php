<?php

namespace App\Exports;

use App\Models\NilaiRaport;
use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use App\Models\Kehadiran;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class NilaiRaportExport implements FromArray, WithStyles, WithColumnWidths
{
    protected $rombelIds;
    protected $search;
    protected $semester;
    protected $tahunAjaran;

    public function __construct($rombelIds = [], $search = null, $semester = null, $tahunAjaran = null)
    {
        $this->rombelIds = $rombelIds;
        $this->search = $search;
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
    }

    public function array(): array
    {
        // Get students
        $query = DataSiswa::with(['rombel', 'nilaiRaports'])
            ->whereIn('rombel_id', $this->rombelIds);

        if ($this->search) {
            $like = '%' . $this->search . '%';
            $query->where(function($q) use ($like) {
                $q->where('nama_lengkap', 'like', $like)
                    ->orWhere('nis', 'like', $like)
                    ->orWhere('nisn', 'like', $like);
            });
        }

        $siswas = $query->orderBy('nama_lengkap')->get();

        if ($siswas->isEmpty()) {
            return [['Tidak ada data siswa']];
        }

        // Get all unique mata pelajaran for the selected students
        $nilaiRaports = NilaiRaport::whereIn('siswa_id', $siswas->pluck('id'))
            ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
            ->when($this->tahunAjaran, fn($q) => $q->where('tahun_ajaran', $this->tahunAjaran))
            ->with('mapel')
            ->get();

        // Get unique mapel, sort by urutan
        $mapelList = [];
        if ($nilaiRaports->isNotEmpty()) {
            $mapelList = $nilaiRaports->pluck('mapel')
                ->filter(fn($m) => $m !== null)
                ->unique('id')
                ->sortBy('urutan')
                ->values()
                ->toArray();
        }

        // Build header
        $data = [];

        // School info
        $data[] = ['Sekolah: SMKN 1 KAWALI'];
        $data[] = ['NPSN: 20233694'];
        $data[] = [];

        // Title
        $data[] = ['LEDGER NILAI RAPORT'];
        $data[] = [];

        // Get first rombel info
        $rombel = $siswas->first()->rombel;
        if ($rombel) {
            $data[] = ['Kelas:', $rombel->nama];
            if ($rombel->waliKelas) {
                $data[] = ['Wali Kelas:', $rombel->waliKelas->nama ?? '-'];
            }
        }

        $data[] = ['Semester:', $this->semester ?? 'Semua'];
        $data[] = ['Tahun Ajaran:', $this->tahunAjaran ?? 'Semua'];
        $data[] = [];

        // Table header row
        $headerRow = ['NO', 'NISN', 'NIS', 'NAMA SISWA'];
        foreach ($mapelList as $mapel) {
            $mapelObj = is_object($mapel) ? $mapel : (object)$mapel;
            $headerRow[] = strtoupper(substr($mapelObj->nama ?? 'MAPEL', 0, 10));
        }
        $headerRow[] = 'SAKIT';
        $headerRow[] = 'IZIN';
        $headerRow[] = 'ALPA';

        $data[] = $headerRow;

        // Data rows
        $no = 1;
        $nilaiList = []; // untuk ranking

        // Index nilai by siswa_id dan mata_pelajaran_id untuk lookup cepat
        $nilaiByStudentAndMapel = [];
        foreach ($nilaiRaports as $nilai) {
            $key = $nilai->siswa_id . '_' . $nilai->mata_pelajaran_id;
            $nilaiByStudentAndMapel[$key] = $nilai->nilai_akhir ?? 0;
        }

        foreach ($siswas as $siswa) {
            $row = [$no, $siswa->nisn, $siswa->nis, $siswa->nama_lengkap];

            $totalNilai = 0;
            $countNilai = 0;

            // Add nilai per mapel
            foreach ($mapelList as $mapel) {
                $mapelObj = is_object($mapel) ? $mapel : (object)$mapel;
                $mapelId = $mapelObj->id ?? null;
                
                $key = $siswa->id . '_' . $mapelId;
                if (isset($nilaiByStudentAndMapel[$key])) {
                    $nilaiValue = $nilaiByStudentAndMapel[$key];
                    $row[] = $nilaiValue;
                    $totalNilai += $nilaiValue;
                    $countNilai++;
                } else {
                    $row[] = '';
                }
            }

            // Get kehadiran
            $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
                ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
                ->when($this->tahunAjaran, fn($q) => $q->where('tahun_ajaran', $this->tahunAjaran))
                ->first();

            $row[] = $kehadiran->sakit ?? 0;
            $row[] = $kehadiran->izin ?? 0;
            $row[] = $kehadiran->alpa ?? 0;

            $data[] = $row;
            $nilaiList[$siswa->id] = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;

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
        // School info styling (rows 1-2)
        $sheet->getStyle('A1:A2')->applyFromArray([
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

        // Title styling (LEDGER NILAI RAPORT)
        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension(4)->setRowHeight(25);

        // Info rows styling
        $sheet->getStyle('A6:B9')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        // Find header row (should be around row 11)
        $headerRow = null;
        $highestRow = $sheet->getHighestRow();
        
        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if ($cellValue === 'NO') {
                $headerRow = $row;
                break;
            }
        }

        if (!$headerRow) {
            $headerRow = 11; // fallback
        }

        // Get the last column with data
        $lastColumn = $sheet->getHighestColumn();
        
        // Header styling
        $headerRange = 'A' . $headerRow . ':' . $lastColumn . $headerRow;
        $sheet->getStyle($headerRange)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '10B981'],
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
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getRowDimension($headerRow)->setRowHeight(25);

        // Data rows styling
        $dataStartRow = $headerRow + 1;
        $dataEndRow = $highestRow;

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
            $sheet->getStyle('D' . $dataStartRow . ':D' . $dataEndRow)->applyFromArray([
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