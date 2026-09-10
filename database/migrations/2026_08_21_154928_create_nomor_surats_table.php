<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nomor_surat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat');
            $table->string('tahun');
            $table->integer('nomor_terakhir')->default(0);
            $table->timestamps();

            $table->unique(['jenis_surat', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nomor_surat');
    }
};