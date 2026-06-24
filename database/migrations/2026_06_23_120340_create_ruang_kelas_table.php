<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruang_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruang', 20)->unique();
            $table->string('nama_ruang');
            $table->string('lantai')->nullable();
            $table->string('gedung')->nullable();
            $table->integer('kapasitas')->default(30);
            $table->string('jenis_ruang')->default('kelas'); 
            $table->text('fasilitas')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruang_kelas');
    }
};