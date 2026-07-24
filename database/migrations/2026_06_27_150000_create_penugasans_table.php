<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * MERGED FROM:
     * - 2026_06_23_060743_create_penugasans_table.php
     * - 2026_06_27_014028_create_penugasans_table.php
     */
    public function up(): void
    {
        Schema::create('penugasans', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('set null');
            
            // Penugasan Information
            $table->string('kategori')->nullable(); // WaliKelas, Kaprog, PKL, Mengajar, etc
            $table->string('detail_objek')->nullable(); // Contoh: 'X RPL 1'
            $table->integer('jumlah_jam')->default(0);
            
            // Academic Period
            $table->string('tahun_ajaran')->nullable();
            $table->string('semester')->nullable(); // Ganjil / Genap
            $table->string('kelas')->nullable();
            
            // Additional Info
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
