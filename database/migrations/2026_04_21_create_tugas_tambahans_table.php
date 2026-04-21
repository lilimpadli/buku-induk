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
        Schema::create('tugas_tambahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->enum('tipe_tugas', ['wali_kelas', 'waka_kesiswaan', 'kaprog']);
            $table->string('tahun_ajaran')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi tugas yang sama untuk guru yang sama
            $table->unique(['guru_id', 'tipe_tugas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_tambahans');
    }
};
