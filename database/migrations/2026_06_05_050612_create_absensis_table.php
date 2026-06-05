<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('input_by')->nullable(); // user_id yang input
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('data_siswa')->onDelete('cascade');
            $table->foreign('input_by')->references('id')->on('users')->onDelete('set null');
            
            // Unique constraint: satu siswa hanya satu absensi per tanggal
            $table->unique(['siswa_id', 'tanggal']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
};