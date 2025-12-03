<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_raports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->string('semester'); // Ganjil/Genap
            $table->string('tahun_ajaran'); // Contoh: 2023/2024
            $table->string('mata_pelajaran');
            $table->integer('kkm')->default(75);
            $table->integer('nilai_pengetahuan')->nullable();
            $table->integer('nilai_keterampilan')->nullable();
            $table->string('predikat_pengetahuan')->nullable();
            $table->string('predikat_keterampilan')->nullable();
            $table->text('deskripsi_pengetahuan')->nullable();
            $table->text('deskripsi_keterampilan')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('siswa_id')->references('id')->on('data_siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_raports');
    }
}