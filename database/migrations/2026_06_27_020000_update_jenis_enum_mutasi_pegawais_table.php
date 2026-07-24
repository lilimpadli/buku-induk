<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Update ENUM options untuk jenis mutasi:
     * FROM: ['Masuk', 'Keluar']
     * TO: ['Masuk', 'Keluar', 'Meninggal', 'Pindah Tugas']
     */
    public function up(): void
    {
        // MySQL: Alter enum column
        DB::statement(
            "ALTER TABLE mutasi_pegawais MODIFY COLUMN jenis ENUM('Masuk', 'Keluar', 'Meninggal', 'Pindah Tugas')"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            "ALTER TABLE mutasi_pegawais MODIFY COLUMN jenis ENUM('Masuk', 'Keluar')"
        );
    }
};
