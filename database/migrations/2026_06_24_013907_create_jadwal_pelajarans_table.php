<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('ruang_kelas_id')->nullable()->constrained('ruang_kelas')->onDelete('set null');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->foreignId('jam_pelajaran_id')->constrained('jam_pelajarans')->onDelete('cascade');
            $table->integer('jam_ke')->default(1);
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi jadwal
            $table->unique(['rombel_id', 'hari', 'jam_pelajaran_id', 'mata_pelajaran_id'], 'unique_jadwal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajarans');
    }
};