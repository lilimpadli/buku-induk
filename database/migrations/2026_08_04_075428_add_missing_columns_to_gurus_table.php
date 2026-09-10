<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            // Kolom yang hilang dan menyebabkan error saat import
            $table->string('pendidikan', 20)->nullable();
            $table->string('email_pribadi', 100)->nullable();
            $table->string('email_resmi', 100)->nullable();
            $table->string('alamat_jalan', 255)->nullable(); // Di error Anda tertulis 'alamat_jalan'
            $table->string('kelurahan', 50)->nullable(); // Di error Anda tertulis 'desa', tapi di form import tertulis Kelurahan. Kita buat keduanya aman.
            $table->string('desa', 50)->nullable(); 
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('no_hp', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn([
                'pendidikan', 
                'email_pribadi', 
                'email_resmi', 
                'alamat_jalan', 
                'kelurahan', 
                'desa', 
                'kode_pos', 
                'telepon', 
                'no_hp'
            ]);
        });
    }
};