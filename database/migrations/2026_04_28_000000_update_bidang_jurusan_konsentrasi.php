<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah nama tabel program_keahlian menjadi konsentrasi_keahlian, dan nama_program menjadi nama_konsentrasi
        Schema::rename('program_keahlian', 'konsentrasi_keahlian');
        Schema::table('konsentrasi_keahlian', function (Blueprint $table) {
            $table->renameColumn('nama_program', 'nama_konsentrasi');
        });

        // 2. Ubah nama_jurusan menjadi nama_keahlian dan hapus id_program di bidang_keahlian
        Schema::table('bidang_keahlian', function (Blueprint $table) {
            $table->renameColumn('nama_jurusan', 'nama_keahlian');
            $table->dropColumn('id_program');
        });

        // 3. Tambah field id_bidang ke tabel jurusans
        Schema::table('jurusans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bidang')->nullable()->after('id');
            $table->foreign('id_bidang')->references('id')->on('bidang_keahlian')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // 1. Balikkan perubahan pada jurusans
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropForeign(['id_bidang']);
            $table->dropColumn('id_bidang');
        });
        // 2. Balikkan perubahan pada bidang_keahlian
        Schema::table('bidang_keahlian', function (Blueprint $table) {
            $table->renameColumn('nama_keahlian', 'nama_jurusan');
            $table->string('id_program', 50)->nullable();
        });
        // 3. Balikkan perubahan pada konsentrasi_keahlian
        Schema::table('konsentrasi_keahlian', function (Blueprint $table) {
            $table->renameColumn('nama_konsentrasi', 'nama_program');
        });
        Schema::rename('konsentrasi_keahlian', 'program_keahlian');
    }
};
