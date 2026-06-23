<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use App\Models\Semester;

class TahunAjaranSeeder extends Seeder
{
public function run()
{
    $tahunAjarans = [
        ['tahun' => '2024/2025', 'tanggal_mulai' => '2024-07-15', 'tanggal_selesai' => '2025-06-30', 'is_active' => true],
        ['tahun' => '2025/2026', 'tanggal_mulai' => '2025-07-15', 'tanggal_selesai' => '2026-06-30', 'is_active' => false],
        ['tahun' => '2026/2027', 'tanggal_mulai' => '2026-07-15', 'tanggal_selesai' => '2027-06-30', 'is_active' => false],
    ];

    foreach($tahunAjarans as $ta) {
        TahunAjaran::updateOrCreate(['tahun' => $ta['tahun']], $ta);
    }
}
}