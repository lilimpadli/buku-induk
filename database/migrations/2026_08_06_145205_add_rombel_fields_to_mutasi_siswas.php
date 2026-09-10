<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            // Tambahkan field untuk rombel asal dan tujuan
            $table->unsignedBigInteger('rombel_asal_id')->nullable()->after('siswa_id');
            $table->unsignedBigInteger('rombel_tujuan_id')->nullable()->after('rombel_asal_id');
            
            // Foreign key ke tabel rombels
            $table->foreign('rombel_asal_id')->references('id')->on('rombels')->onDelete('set null');
            $table->foreign('rombel_tujuan_id')->references('id')->on('rombels')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            $table->dropForeign(['rombel_asal_id']);
            $table->dropForeign(['rombel_tujuan_id']);
            $table->dropColumn(['rombel_asal_id', 'rombel_tujuan_id']);
        });
    }
};