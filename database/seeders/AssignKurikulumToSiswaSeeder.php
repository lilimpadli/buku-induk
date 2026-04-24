<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignKurikulumToSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign kurikulum_id 2 untuk kelas X dan XI
        DB::table('data_siswa')
            ->join('rombels', 'data_siswa.rombel_id', '=', 'rombels.id')
            ->join('kelas', 'rombels.kelas_id', '=', 'kelas.id')
            ->whereIn('kelas.tingkat', ['X', 'XI'])
            ->update(['data_siswa.kurikulum_id' => 2]);

        // Assign kurikulum_id 1 untuk kelas XII
        DB::table('data_siswa')
            ->join('rombels', 'data_siswa.rombel_id', '=', 'rombels.id')
            ->join('kelas', 'rombels.kelas_id', '=', 'kelas.id')
            ->where('kelas.tingkat', '=', 'XII')
            ->update(['data_siswa.kurikulum_id' => 1]);

        echo "✓ Kurikulum berhasil diassign!\n";
        echo "  - Kelas X & XI: kurikulum_id 2\n";
        echo "  - Kelas XII: kurikulum_id 1\n";
    }
}
