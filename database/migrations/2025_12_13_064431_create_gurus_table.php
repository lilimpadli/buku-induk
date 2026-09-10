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

            // --- SESUAI DENGAN GAMBAR KANAN ANDA ---
            $table->string('nama', 100)->nullable();
            $table->string('nik', 20)->nullable()->unique();
            $table->string('nuptk', 30)->nullable();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('status_kepegawaian', 50)->nullable();
            $table->string('jenis_kelamin', 10)->nullable(); // JK
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('serdik', 50)->nullable();
            
            $table->string('email_pribadi', 100)->nullable();
            $table->string('email_resmi', 100)->nullable();
            
            // Alamat Detail (Sesuai Import)
            $table->text('alamat')->nullable(); // Ubah 'alamat_jalan' jadi 'alamat' agar pas dengan kolom di form
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('dusun', 50)->nullable();
            $table->string('kelurahan', 50)->nullable(); // Gambar kanan menggunakan 'Kelurahan'
            $table->string('kecamatan', 50)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('no_hp', 20)->nullable(); // Gambar kanan menggunakan 'No HP'

            // --- KOLOM LAINNYA (WAJIB) ---
            $table->string('email', 100)->nullable()->unique(); // Email utama untuk login
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};