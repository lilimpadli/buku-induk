<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nilai_raports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mata_pelajaran_id');

            $table->string('semester');            // Ganjil / Genap
            $table->string('tahun_ajaran');        // 2024/2025

            $table->integer('nilai_akhir')->nullable();
            $table->text('deskripsi')->nullable(); // Capaian kompetensi

            $table->timestamps();

            // FK
            $table->foreign('siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');

            $table->foreign('mata_pelajaran_id')
                ->references('id')->on('mata_pelajarans')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_raports');
    }
};
