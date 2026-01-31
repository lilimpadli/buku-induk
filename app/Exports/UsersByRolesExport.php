<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersByRolesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $roles;
    protected $title;

    public function __construct(array $roles = [], $title = 'Users')
    {
        $this->roles = $roles;
        $this->title = $title;
    }

    public function collection()
    {
        $query = User::query();
        if (!empty($this->roles)) {
            $query->whereIn('role', $this->roles);
        }

        $users = $query->orderBy('name')->get();

        return $users->map(function ($u, $k) {
            return [
                'No' => $k + 1,
                'Nama' => $u->name,
                'Nomor Induk' => $u->nomor_induk ?? '',
                'Email' => $u->email ?? '',
                'Role' => $u->role ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Nomor Induk', 'Email', 'Role'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Title row
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                $sheet->setCellValue('A1', strtoupper('DATA PENGGUNA - ' . $this->title));
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Header bold
                $sheet->getStyle('A2:' . $highestColumn . '2')->getFont()->setBold(true);

                // Borders
                $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
