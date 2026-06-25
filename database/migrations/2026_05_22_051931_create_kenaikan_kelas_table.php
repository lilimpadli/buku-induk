<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('kenaikan_kelas')) {
            Schema::create('kenaikan_kelas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id'); // sesuaikan dengan referensi Anda
                $table->string('kelas_lama');
                $table->string('kelas_baru');
                $table->string('tahun_ajaran');
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kenaikan_kelas');
    }
};
