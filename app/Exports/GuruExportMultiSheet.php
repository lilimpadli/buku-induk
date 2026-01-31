<?php

namespace App\Exports;

use App\Exports\Sheets\TuUsersSheet;
use App\Exports\Sheets\StaffGroupSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class GuruExportMultiSheet implements WithMultipleSheets, WithEvents
{
    public function sheets(): array
    {
        return [
            new TuUsersSheet(),
            new StaffGroupSheet(),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Header bold
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('DDDDDD'));

                // Borders
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
