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
    Schema::create('kelas', function (Blueprint $table) {
        $table->id();
        $table->string('tingkat', 10);  // X, XI, XII
        $table->unsignedBigInteger('jurusan_id');
        $table->timestamps();

        $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('kelas');
}

};
