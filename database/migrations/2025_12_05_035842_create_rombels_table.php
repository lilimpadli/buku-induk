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
            $table->string('nama', 50);
            
            // Ubah dari wali_kelas_id menjadi guru_id agar sesuai dengan migrasi selanjutnya
            $table->unsignedBigInteger('guru_id')->nullable(); 
            
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            // Jika ada tabel 'gurus', Anda bisa tambahkan ini:
            // $table->foreign('guru_id')->references('id')->on('gurus')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rombels');
    }
};