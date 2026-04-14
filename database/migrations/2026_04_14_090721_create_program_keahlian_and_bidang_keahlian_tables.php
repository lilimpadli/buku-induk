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
        // Tabel program_keahlian
        Schema::create('program_keahlian', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program', 100);
            $table->string('id_jurusan', 50);
            $table->timestamps();
        });

        // Tabel bidang_keahlian
        Schema::create('bidang_keahlian', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan', 100);
            $table->string('id_program', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang_keahlian');
        Schema::dropIfExists('program_keahlian');
    }
};
