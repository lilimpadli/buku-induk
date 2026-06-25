<?php

namespace App\Exports;

use App\Models\DataSiswa;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class NilaiRaportTemplateByFilters implements FromArray, WithStyles, WithColumnWidths
{
    protected $kurikulumIds;
    protected $jurusanIds;
    protected $tingkatLevels;

    public function __construct($kurikulumIds = [], $jurusanIds = [], $tingkatLevels = [])
    {
        $this->kurikulumIds = (array)$kurikulumIds;
        $this->jurusanIds = (array)$jurusanIds;
        $this->tingkatLevels = (array)$tingkatLevels;
    }

    public function array(): array
    {
        // Get mata pelajaran based on kurikulum and jurusan filters
        $mataPelajaranQuery = MataPelajaran::query();
        
        if (!empty($this->kurikulumIds)) {
            $mataPelajaranQuery->whereHas('kurikulums', function ($q) {
                $q->whereIn('kurikulum_id', $this->kurikulumIds);
            });
        }
        
        if (!empty($this->jurusanIds)) {
            $mataPelajaranQuery->whereHas('jurusans', function ($q) {
                $q->whereIn('jurusan_id', $this->jurusanIds);
            });
        }
        
        $mataPelajarans = $mataPelajaranQuery->orderBy('nama')->get();

        // Get kurikulum names
        $kurikulums = \App\Models\Kurikulum::whereIn('id', $this->kurikulumIds)->pluck('nama_kurikulum')->toArray();
        
        // Get jurusan names
        $jurusans = \App\Models\Jurusan::whereIn('id', $this->jurusanIds)->pluck('nama')->toArray();

        // Get students filtered by jurusan and tingkat
        $siswasQuery = DataSiswa::with('rombel.kelas.jurusan');
        
        if (!empty($this->jurusanIds)) {
            $siswasQuery->whereHas('rombel.kelas', function ($q) {
                $q->whereIn('jurusan_id', $this->jurusanIds);
            });
        }
        
        if (!empty($this->tingkatLevels)) {
            $siswasQuery->whereHas('rombel.kelas', function ($q) {
                $q->whereIn('tingkat', $this->tingkatLevels);
            });
        }

        // Get all students matching the filter criteria
        $siswas = $siswasQuery->orderBy('nama_lengkap')->get();

        // Build info rows at top
        $data = [];
        $data[] = ['TEMPLATE IMPORT NILAI RAPOR'];
        $data[] = [];
        
        if (!empty($kurikulums)) {
            $data[] = ['KURIKULUM:', implode(', ', $kurikulums)];
        }
        if (!empty($jurusans)) {
            $data[] = ['JURUSAN:', implode(', ', $jurusans)];
        }
        if (!empty($this->tingkatLevels)) {
            $data[] = ['TINGKAT:', implode(', ', $this->tingkatLevels)];
        }
        
        $data[] = [];

        // Build header row
        $headers = ['No', 'NIS', 'NISN', 'Nama Siswa', 'Rombel'];
        foreach ($mataPelajarans as $mp) {
            $headers[] = substr($mp->nama, 0, 15); // Abbreviated
        }
        $headers[] = 'Kehadiran - Sakit';
        $headers[] = 'Kehadiran - Izin';
        $headers[] = 'Kehadiran - Alpa';
        $headers[] = 'Catatan';

        $data[] = $headers;

        // Build data rows
        $no = 1;
        foreach ($siswas as $siswa) {
            $row = [
                $no++,
                $siswa->nis ?? '',
                $siswa->nisn ?? '',
                $siswa->nama_lengkap,
                $siswa->rombel ? $siswa->rombel->nama : '',
            ];

            // Add empty cells for mata pelajaran values
            foreach ($mataPelajarans as $mp) {
                $row[] = '';
            }

            // Add empty kehadiran fields
            $row[] = 0; // Sakit
            $row[] = 0; // Izin
            $row[] = 0; // Alpa
            $row[] = ''; // Catatan

            $data[] = $row;
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Style info rows (1-5) with light gray background
        $sheet->getStyle('1:5')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8E8E8'],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
        ]);

        // Style title row
        $sheet->getStyle('1:1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '366092'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
        ]);

        // Style header row (row 6 - after info rows)
        $sheet->getStyle('6:6')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 5,   // No
            'B' => 12,  // NIS
            'C' => 12,  // NISN
            'D' => 25,  // Nama Siswa
            'E' => 12,  // Rombel
        ];

        $currentColumn = 'F';
        for ($i = 0; $i < 20; $i++) {
            $widths[$currentColumn] = 10;
            $currentColumn = $this->nextColumn($currentColumn);
        }

        $widths[$currentColumn] = 12; // Sakit
        $currentColumn = $this->nextColumn($currentColumn);
        $widths[$currentColumn] = 12; // Izin
        $currentColumn = $this->nextColumn($currentColumn);
        $widths[$currentColumn] = 12; // Alpa
        $currentColumn = $this->nextColumn($currentColumn);
        $widths[$currentColumn] = 15; // Catatan

        return $widths;
    }

    protected function nextColumn(string $column): string
    {
        $letters = str_split($column);
        $index = count($letters) - 1;

        while ($index >= 0) {
            if ($letters[$index] !== 'Z') {
                $letters[$index] = chr(ord($letters[$index]) + 1);
                return implode('', $letters);
            }

            $letters[$index] = 'A';
            $index--;
        }

        array_unshift($letters, 'A');
        return implode('', $letters);
    }
}
