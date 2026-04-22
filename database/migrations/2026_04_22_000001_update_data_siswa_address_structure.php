<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // Tambah field kewarganegaraan
            $table->string('kewarganegaraan')->nullable()->after('agama');

            // Hapus field alamat lama dan tambah field-field alamat baru
            $table->dropColumn('alamat');
            
            // Tambah field alamat terstruktur
            $table->string('rt')->nullable()->after('kewarganegaraan');
            $table->string('rw')->nullable()->after('rt');
            $table->string('dusun')->nullable()->after('rw');
            $table->string('kelurahan')->nullable()->after('dusun');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kode_pos')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // Reverse: hapus field-field baru
            $table->dropColumn(['kewarganegaraan', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kode_pos']);
            
            // Kembalikan field alamat lama
            $table->text('alamat')->nullable();
        });
    }
};
