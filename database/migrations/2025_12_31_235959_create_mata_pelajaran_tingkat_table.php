<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mata_pelajaran_tingkat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_pelajaran_id');
            $table->tinyInteger('tingkat')->comment('tingkat: 10,11,12');
            $table->timestamps();

            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajarans')->onDelete('cascade');
            $table->unique(['mata_pelajaran_id','tingkat']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mata_pelajaran_tingkat');
    }
};
