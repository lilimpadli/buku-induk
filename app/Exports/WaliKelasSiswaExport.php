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
    protected $rombelId;
    protected $kelasName;

    // Ubah parameter pertama dari array menjadi int/string
    public function __construct($rombelId = null, $kelasName = '')
    {
        $this->rombelId = $rombelId;
        $this->kelasName = $kelasName;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DataSiswa::query()->with('rombel');

        // Filter berdasarkan rombel_id jika ada
        if ($this->rombelId) {
            $query->where('rombel_id', $this->rombelId);
        }

        $students = $query->orderBy('nama_lengkap')->get();
        
        $rows = $students->map(function ($s, $k) {
            $tempatTanggalLahir = '';
            if ($s->tempat_lahir && $s->tanggal_lahir) {
                $tanggal = \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y');
                $tempatTanggalLahir = $s->tempat_lahir . ', ' . $tanggal;
            } elseif ($s->tempat_lahir) {
                $tempatTanggalLahir = $s->tempat_lahir;
            } elseif ($s->tanggal_lahir) {
                $tempatTanggalLahir = \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y');
            }

            return [
                'No' => $k + 1,
                'NIS' => $s->nis ?? '',
                'NISN' => $s->nisn ?? '',
                'Nama' => $s->nama_lengkap,
                'JK' => $s->jenis_kelamin,
                'TTL' => $tempatTanggalLahir,
            ];
        });

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'NIS', 'NISN', 'Nama', 'Jenis Kelamin', 'Tempat, Tanggal Lahir'
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
                $title = $this->kelasName ? 'DATA SISWA KELAS ' . $this->kelasName : 'DATA SISWA';
                $sheet->setCellValue('A1', $title);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Apply styling to headers (now at row 2)
                $sheet->getStyle('A2:F2')->getFont()->setBold(true);
                $sheet->getStyle('A2:F2')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFDDDDDD');
                
                // Add borders to the table (from headers to last row)
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A2:F' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}