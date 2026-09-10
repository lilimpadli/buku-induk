<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nik', 20)->nullable();
            $table->string('nuptk', 30)->nullable();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_kepegawaian', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 50)->nullable(); // Untuk TU / Kepegawaian
            $table->text('alamat')->nullable();
            
            // Hubungkan ke tabel users
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};