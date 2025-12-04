<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rapor_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');

            $table->string('semester');
            $table->string('tahun_ajaran');

            $table->string('wali_kelas')->nullable();
            $table->string('nip_wali')->nullable();

            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepsek')->nullable();

            $table->date('tanggal_rapor')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rapor_infos');
    }
};
