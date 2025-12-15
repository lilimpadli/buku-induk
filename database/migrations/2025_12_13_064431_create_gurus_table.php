<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 100);
            $table->string('nip', 30)->unique();
            $table->string('email', 100)->unique();

            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();

            $table->foreignId('jurusan_id')
                  ->nullable()
                  ->constrained('jurusans')
                  ->nullOnDelete();

            $table->foreignId('kelas_id')
                  ->nullable()
                  ->constrained('kelas')
                  ->nullOnDelete();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
