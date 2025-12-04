<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ekstrakurikuler_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->string('nama_ekstra');
            $table->string('predikat')->nullable();   // SB, B, C
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('data_siswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ekstrakurikuler_siswa');
    }
};
