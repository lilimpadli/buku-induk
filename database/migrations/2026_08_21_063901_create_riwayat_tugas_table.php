<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_tugas', function (Blueprint $table) {
            $table->id();

            // PERBAIKAN: Tambahkan kolom pegawai_id agar terhubung ke data pegawai
            $table->foreignId('pegawai_id')
                  ->constrained('pegawais')
                  ->cascadeOnDelete();

            $table->string('instansi');
            $table->string('jabatan');
            $table->date('mulai');
            
            // PERBAIKAN: Sesuaikan dengan Model Anda
            $table->boolean('is_tugas_tambahan')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_tugas');
    }
};