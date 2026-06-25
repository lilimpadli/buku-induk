<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();

            // relasi ke tahun ajaran
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->onDelete('cascade');

            // semester (1 / 2)
            $table->enum('semester', ['1', '2']);

            // periode semester
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // status
            $table->boolean('is_active')->default(false);
            $table->boolean('is_current')->default(false);

            // tambahan info
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // biar gak dobel semester dalam 1 tahun ajaran
            $table->unique(['tahun_ajaran_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};