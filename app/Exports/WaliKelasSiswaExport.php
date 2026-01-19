<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class WaliKelasSiswaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $rombelsIds;
    protected $kelasName;

    public function __construct(array $rombelsIds = [], $kelasName = 'X RPL 2')
    {
        $this->rombelsIds = $rombelsIds;
        $this->kelasName = $kelasName;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DataSiswa::query()->with('rombel');

        if (!empty($this->rombelsIds)) {
            $query->whereIn('rombel_id', $this->rombelsIds);
        }

        $students = $query->orderBy('nama_lengkap')->get();
        
        $rows = $students->map(function ($s, $k) {
            return [
                'No' => $k + 1,
                'NISN' => $s->nisn,
                'NIS' => $s->nis ?? '',
                'Nama' => $s->nama_lengkap,
                'JK' => $s->jenis_kelamin,
                'Tempat Lahir' => $s->tempat_lahir,
                'Tanggal Lahir' => $s->tanggal_lahir,
            ];
        });

        // Add total row
        $rows->push([
            'No' => '',
            'NISN' => '',
            'NIS' => '',
            'Nama' => 'JUMLAH',
            'JK' => '',
            'Tempat Lahir' => '',
            'Tanggal Lahir' => $students->count(),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'NISN', 'NIS', 'Nama', 'JK', 'Tempat Lahir', 'Tanggal Lahir'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Add title
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'DATA SISWA KELAS ' . $this->kelasName);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                // Shift headers down by 1 row
                $sheet->insertNewRowBefore(2, 1);
                
                // Apply styling to headers
                $sheet->getStyle('A2:G2')->getFont()->setBold(true);
                $sheet->getStyle('A2:G2')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFDDDDDD');
                
                // Style the total row
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A' . $highestRow . ':G' . $highestRow)->getFont()->setBold(true);
                
                // Add borders to the table
                $sheet->getStyle('A2:G' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}