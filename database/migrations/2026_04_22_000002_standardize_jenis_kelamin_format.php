<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Standardisasi jenis_kelamin di table data_siswa
        // Ubah 'L' menjadi 'Laki-laki'
        DB::table('data_siswa')
            ->where('jenis_kelamin', 'L')
            ->update(['jenis_kelamin' => 'Laki-laki']);

        // Ubah 'P' menjadi 'Perempuan'
        DB::table('data_siswa')
            ->where('jenis_kelamin', 'P')
            ->update(['jenis_kelamin' => 'Perempuan']);
    }

    public function down(): void
    {
        // Reverse: Ubah 'Laki-laki' menjadi 'L'
        DB::table('data_siswa')
            ->where('jenis_kelamin', 'Laki-laki')
            ->update(['jenis_kelamin' => 'L']);

        // Ubah 'Perempuan' menjadi 'P'
        DB::table('data_siswa')
            ->where('jenis_kelamin', 'Perempuan')
            ->update(['jenis_kelamin' => 'P']);
    }
};
