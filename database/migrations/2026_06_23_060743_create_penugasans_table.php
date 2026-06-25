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
        Schema::create('penugasans', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom di bawah ini:
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('kategori'); // WaliKelas, Kaprog, PKL, Mengajar
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('set null');
            $table->string('detail_objek'); // Contoh: 'X RPL 1'
            $table->integer('jumlah_jam')->default(0);
            $table->string('tahun_ajaran');
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