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
        Schema::create('mutasi_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->enum('status', ['pindah', 'do', 'meninggal', 'naik_kelas', 'lulus'])->default('naik_kelas');
            $table->date('tanggal_mutasi');
            $table->text('keterangan')->nullable();
            $table->string('alasan_pindah')->nullable(); // Jika pindah
            $table->string('no_sk_keluar')->nullable(); // Surat Keputusan keluar
            $table->date('tanggal_sk_keluar')->nullable();
            $table->string('tujuan_pindah')->nullable(); // Sekolah tujuan jika pindah
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('data_siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_siswas');
    }
};
