<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // Field PKL
            $table->string('pkl_nilai')->nullable();
            $table->string('pkl_sertifikat')->nullable();
            $table->string('pkl_nama_industri')->nullable();
            $table->text('pkl_alamat')->nullable();

            // Field Ijazah / Kelulusan
            $table->string('ijazah_nomor')->nullable();
            $table->date('ijazah_tanggal')->nullable();
            $table->string('transkip_nomor')->nullable();
            $table->date('transkip_tanggal')->nullable();

            // Field Lulus/Tamat
            $table->date('tanggal_lulus')->nullable();
            $table->string('status_kelulusan')->nullable(); // Lulus / Tidak Lulus
        });
    }

    public function down()
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->dropColumn([
                'pkl_nilai',
                'pkl_sertifikat',
                'pkl_nama_industri',
                'pkl_alamat',
                'ijazah_nomor',
                'ijazah_tanggal',
                'transkip_nomor',
                'transkip_tanggal',
                'tanggal_lulus',
                'status_kelulusan',
            ]);
        });
    }
};