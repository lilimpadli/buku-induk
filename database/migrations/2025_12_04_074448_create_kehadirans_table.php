<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');

            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('tanpa_keterangan')->default(0);

            $table->string('semester');
            $table->string('tahun_ajaran');
            $table->timestamps();

            $table->foreign('siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kehadirans');
    }
};
