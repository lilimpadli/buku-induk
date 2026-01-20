<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // Tambahkan unique constraint untuk NIS dan NISN
            // Gunakan rawSql untuk nullable unique
            $this->createUniqueConstraint('nis');
            $this->createUniqueConstraint('nisn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // Drop unique constraints
            try {
                DB::statement('ALTER TABLE data_siswa DROP INDEX unique_nis');
            } catch (\Exception $e) {
                // Index tidak ada
            }
            
            try {
                DB::statement('ALTER TABLE data_siswa DROP INDEX unique_nisn');
            } catch (\Exception $e) {
                // Index tidak ada
            }
        });
    }

    /**
     * Create unique constraint for nullable column
     */
    private function createUniqueConstraint($column)
    {
        try {
            if ($column === 'nis') {
                DB::statement('ALTER TABLE data_siswa ADD UNIQUE KEY unique_nis (nis)');
            } elseif ($column === 'nisn') {
                DB::statement('ALTER TABLE data_siswa ADD UNIQUE KEY unique_nisn (nisn)');
            }
        } catch (\Exception $e) {
            // Constraint sudah ada atau error lain, skip
        }
    }
};
