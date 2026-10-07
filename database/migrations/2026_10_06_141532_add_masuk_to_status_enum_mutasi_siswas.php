<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'masuk' ke enum status
        DB::statement("
            ALTER TABLE mutasi_siswas 
            MODIFY COLUMN status ENUM(
                'masuk',
                'pindah',
                'do',
                'meninggal',
                'naik_kelas',
                'lulus'
            ) NOT NULL DEFAULT 'naik_kelas'
        ");
    }

    public function down(): void
    {
        // Rollback: hapus 'masuk' dari enum
        // ⚠️ Kalau ada data dengan status='masuk', migrate:rollback akan ERROR
        // Solusi: ubah dulu data 'masuk' ke status lain sebelum rollback
        DB::statement("
            ALTER TABLE mutasi_siswas 
            MODIFY COLUMN status ENUM(
                'pindah',
                'do',
                'meninggal',
                'naik_kelas',
                'lulus'
            ) NOT NULL DEFAULT 'naik_kelas'
        ");
    }
};