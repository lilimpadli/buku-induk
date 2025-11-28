<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Untuk nama lengkap
            $table->string('name');

            // Untuk login menggunakan NIS (siswa) atau NIP (guru/staff)
            $table->string('nomor_induk')->unique()
                  ->comment('NIS untuk siswa, NIP untuk guru/pegawai');

            // Foto profil (boleh kosong)
            $table->string('photo')->nullable();

            // Email (opsional)
            $table->string('email')->nullable()->unique();

            // Role
            $table->enum('role', [
                'siswa',
                'walikelas',
                'kaprog',
                'tu',
                'kurikulum',
                'calon_siswa'
            ]);

            // Password disimpan biasa
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
