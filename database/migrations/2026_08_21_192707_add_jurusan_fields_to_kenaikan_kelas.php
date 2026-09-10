<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable()->after('siswa_id');
            $table->string('kelas_tingkat')->nullable()->after('jurusan_id');
            
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['jurusan_id', 'kelas_tingkat']);
        });
    }
};