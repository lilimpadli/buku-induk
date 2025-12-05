<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kenaikan_kelas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('siswa_id');
            $table->string('semester');         // Ganjil / Genap
            $table->string('tahun_ajaran');     // 2024/2025

            $table->enum('status', [
                'Naik Kelas',
                'Tidak Naik',
                'Lulus'
            ])->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('data_siswa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kenaikan_kelas');
    }
};
