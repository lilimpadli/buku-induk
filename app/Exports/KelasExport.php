<?php

namespace App\Exports;

use App\Models\Rombel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KelasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        $rombels = Rombel::with(['kelas.jurusan', 'guru'])->orderBy('nama')->get();

        return $rombels->map(function ($rombel, $index) {
            return [
                'No' => $index + 1,
                'Nama Rombel' => $rombel->nama,
                'Kelas' => $rombel->kelas->tingkat ?? '-',
                'Jurusan' => $rombel->kelas->jurusan->nama ?? '-',
                'Wali Kelas' => $rombel->guru->nama ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Rombel', 'Kelas', 'Jurusan', 'Wali Kelas'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A1:E1')->getFont()->setBold(true);
                $sheet->getStyle('A1:E' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEEF2FF');
            },
        ];
    }
}
