<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StaffGroupSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $roles = ['guru', 'walikelas', 'kurikulum', 'kaprog'];
        $users = User::whereIn('role', $roles)->orderBy('name')->get();

        return $users->map(function ($u, $k) {
            return [
                'No' => $k + 1,
                'Nama' => $u->name,
                'Nomor Induk' => $u->nomor_induk ?? '',
                'Email' => $u->email ?? '',
                'Role' => $u->role,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Nomor Induk', 'Email', 'Role'];
    }

    public function title(): string
    {
        return 'Guru_Walikelas_Kurikulum_Kaprog';
    }
}
