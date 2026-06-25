<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kkm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
            $table->decimal('nilai_kkm', 5, 2)->default(75.00);
            $table->timestamps();
            
            // Biar tidak ada duplikasi data untuk kombinasi yang sama
            $table->unique(['mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id'], 'unique_kkm');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kkm');
    }
};