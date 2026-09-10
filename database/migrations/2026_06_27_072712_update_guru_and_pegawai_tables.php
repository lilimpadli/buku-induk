<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
{
    Schema::table('gurus', function (Blueprint $table) {
        $table->string('nik')->nullable();
        $table->string('nuptk')->nullable();
        $table->string('serdik')->nullable();
        $table->string('email_resmi')->nullable();
        $table->string('email_pribadi')->nullable();
        $table->enum('status_keaktifan', ['Aktif', 'Keluar'])->default('Aktif');
    });

    Schema::table('pegawais', function (Blueprint $table) {
        $table->string('nik')->nullable();
        $table->string('email_resmi')->nullable();
        $table->string('email_pribadi')->nullable();
        $table->enum('status_keaktifan', ['Aktif', 'Keluar'])->default('Aktif');
    });
}

public function down(): void
{
    Schema::table('gurus', function (Blueprint $table) {
        $table->dropColumn(['nik', 'nuptk', 'serdik', 'email_resmi', 'email_pribadi', 'status_keaktifan']);
    });
    
    Schema::table('pegawais', function (Blueprint $table) {
        $table->dropColumn(['nik', 'email_resmi', 'email_pribadi', 'status_keaktifan']);
    });
}
};
