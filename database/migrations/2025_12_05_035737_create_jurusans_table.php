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
    Schema::create('jurusans', function (Blueprint $table) {
        $table->id();
        $table->string('kode', 10);     // RPL, TKJ, AKL
        $table->string('nama', 100);    // Rekayasa Perangkat Lunak
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('jurusans');
}

};
