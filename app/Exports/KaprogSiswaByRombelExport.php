<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KaprogSiswaByRombelExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $rombelId;
    protected $rombelName;

    public function __construct($rombelId, $rombelName = 'Rombel')
    {
        $this->rombelId = $rombelId;
        $this->rombelName = $rombelName;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $students = DataSiswa::with('rombel.kelas.jurusan')
            ->where('rombel_id', $this->rombelId)
            ->orderBy('nama_lengkap')
            ->get();
        
        $rows = $students->map(function ($s, $k) {
            $tempatTanggalLahir = '';
            if ($s->tempat_lahir && $s->tanggal_lahir) {
                $tanggal = \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y');
                $tempatTanggalLahir = $s->tempat_lahir . ',' . $tanggal;
            } elseif ($s->tempat_lahir) {
                $tempatTanggalLahir = $s->tempat_lahir;
            } elseif ($s->tanggal_lahir) {
                $tanggal = \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y');
                $tempatTanggalLahir = $tanggal;
            }

            return [
                'No' => $k + 1,
                'NIS' => $s->nis ?? '',
                'NISN' => $s->nisn,
                'Nama' => $s->nama_lengkap,
                'JK' => $s->jenis_kelamin,
                'TTL' => $tempatTanggalLahir,
            ];
        });

        // Add total row
        $rows->push([
            'No' => '',
            'NIS' => '',
            'NISN' => '',
            'Nama' => 'JUMLAH',
            'JK' => '',
            'TTL' => $students->count(),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'NIS', 'NISN', 'Nama', 'JK', 'Tempat Lahir, Tanggal Lahir'
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
                
                // Insert a row at the beginning for title
                $sheet->insertNewRowBefore(1, 1);
                
                // Add title
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'DATA SISWA ROMBEL ' . $this->rombelName);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Apply styling to headers (now at row 2)
                $sheet->getStyle('A2:F2')->getFont()->setBold(true);
                $sheet->getStyle('A2:F2')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DDDDDD'));
                
                // Add borders to all cells with data
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
