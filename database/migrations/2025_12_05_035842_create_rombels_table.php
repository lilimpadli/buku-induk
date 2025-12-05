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
    Schema::create('rombels', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kelas_id');
        $table->string('nama', 50);         // RPL 1, TKJ 2
        $table->unsignedBigInteger('wali_kelas_id')->nullable();  // user id
        $table->timestamps();

        $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('rombels');
}

};
