<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->renameColumn('ayah_id', 'nama_ayah');
        });
    }

    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->renameColumn('nama_ayah', 'ayah_id');
        });
    }
};