<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiRekapExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $kelasName;
    protected $bulan;
    protected $semester;

    public function __construct($data, $kelasName, $bulan, $semester)
    {
        $this->data = collect($data);
        $this->kelasName = $kelasName;
        $this->bulan = $bulan;
        $this->semester = $semester;
    }

    public function collection()
    {
        // Tambahkan baris total di akhir
        $totalHadir = $this->data->sum('Hadir');
        $totalSakit = $this->data->sum('Sakit');
        $totalIzin = $this->data->sum('Izin');
        $totalAlpha = $this->data->sum('Alpha');
        $grandTotal = $totalHadir + $totalSakit + $totalIzin + $totalAlpha;
        $avgKehadiran = $grandTotal > 0 ? round(($totalHadir / $grandTotal) * 100, 2) : 0;
        
        $rows = $this->data;
        
        $rows->push([
            'Nama Siswa' => 'TOTAL',
            'NIS' => '',
            'Hadir' => $totalHadir,
            'Sakit' => $totalSakit,
            'Izin' => $totalIzin,
            'Alpha' => $totalAlpha,
            'Total' => $grandTotal,
            'Persentase' => $avgKehadiran . '%',
        ]);
        
        return $rows;
    }

    public function headings(): array
    {
        $bulanText = '';
        if ($this->bulan && $this->bulan != 'all') {
            $bulanText = \Carbon\Carbon::create()->month($this->bulan)->translatedFormat('F');
        } else {
            $bulanText = 'Semester ' . $this->semester;
        }
        
        return [
            ['REKAP ABSENSI SISWA KELAS ' . $this->kelasName],
            ['Periode: ' . $bulanText],
            [],
            ['Nama Siswa', 'NIS', 'Hadir', 'Sakit', 'Izin', 'Alpha', 'Total', 'Persentase']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge title cells
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        
        // Style title
        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
        
        // Style headers
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);
        $sheet->getStyle('A4:H4')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDDDDDD');
        
        // Style total row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . $lastRow . ':H' . $lastRow)->getFont()->setBold(true);
        
        // Add borders
        $sheet->getStyle('A4:H' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        return [];
    }
}