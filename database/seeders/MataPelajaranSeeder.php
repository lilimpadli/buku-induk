<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mataPelajaran = [
            ['nama' => 'DPK', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Informatika', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Pelajaran Pilihan', 'kkm' => 75, 'kelompok' => 'Peminatan'],
            ['nama' => 'Bahasa Indonesia', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Matematika', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'PKN', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Sejarah', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Bahasa Inggris', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Seni Budaya', 'kkm' => 75, 'kelompok' => 'Wajib'],
            ['nama' => 'Penjaskes', 'kkm' => 75, 'kelompok' => 'Wajib'],
        ];

        foreach ($mataPelajaran as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}