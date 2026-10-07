<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            // Field khusus mutasi masuk
            $table->string('sekolah_asal', 255)->nullable()->after('tujuan_pindah');
            $table->string('nis_dari_sekolah_asal', 30)->nullable()->after('sekolah_asal');
            $table->date('tanggal_masuk')->nullable()->after('nis_dari_sekolah_asal');
            $table->string('no_surat_masuk', 100)->nullable()->after('tanggal_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            $table->dropColumn([
                'sekolah_asal',
                'nis_dari_sekolah_asal',
                'tanggal_masuk',
                'no_surat_masuk',
            ]);
        });
    }
};