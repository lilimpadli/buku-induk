<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            if (Schema::hasColumn('data_siswa', 'ayah_id')) {
                $table->renameColumn('ayah_id', 'nama_ayah');
            }
            if (Schema::hasColumn('data_siswa', 'ibu_id')) {
                $table->renameColumn('ibu_id', 'nama_ibu');
            }
            if (Schema::hasColumn('data_siswa', 'wali_id')) {
                $table->renameColumn('wali_id', 'nama_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            if (Schema::hasColumn('data_siswa', 'nama_ayah')) {
                $table->renameColumn('nama_ayah', 'ayah_id');
            }
            if (Schema::hasColumn('data_siswa', 'nama_ibu')) {
                $table->renameColumn('nama_ibu', 'ibu_id');
            }
            if (Schema::hasColumn('data_siswa', 'nama_wali')) {
                $table->renameColumn('nama_wali', 'wali_id');
            }
        });
    }
};