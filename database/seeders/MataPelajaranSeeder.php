<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run()
    {
        $mataPelajaran = [
            ['nama' => 'DPK', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Informatika', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Pelajaran Pilihan', 'kkm' => 75, 'kelompok' => 'B'],
            ['nama' => 'Bahasa Indonesia', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Matematika', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'PKN', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Sejarah', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Bahasa Inggris', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Seni Budaya', 'kkm' => 75, 'kelompok' => 'A'],
            ['nama' => 'Penjaskes', 'kkm' => 75, 'kelompok' => 'A'],
        ];

        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}