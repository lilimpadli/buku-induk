<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('wali_kelas')) {
            Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedBigInteger('rombel_id')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            $table->enum('status', ['Aktif','Tidak Aktif'])->default('Aktif');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('set null');
            $table->foreign('rombel_id')->references('id')->on('rombels')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('wali_kelas');
    }
};
