<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            // Data Siswa
            $table->string('nama_lengkap');
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama')->nullable();

            $table->string('status_keluarga')->nullable(); // Anak kandung, dsb
            $table->integer('anak_ke')->nullable();

            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();

            $table->string('sekolah_asal')->nullable();
            $table->string('kelas')->nullable();
            $table->date('tanggal_diterima')->nullable();

            // Data Ayah
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('telepon_ayah')->nullable();

            // Data Ibu
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('telepon_ibu')->nullable();

            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('telepon_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();

            // Foto
            $table->string('foto')->nullable(); // path foto siswa

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_siswa');
    }
};
