<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            // Tambahkan rombel_asal_id
            if (!Schema::hasColumn('mutasi_siswas', 'rombel_asal_id')) {
                $table->unsignedBigInteger('rombel_asal_id')->nullable()->after('siswa_id');
                $table->foreign('rombel_asal_id')->references('id')->on('rombels')->onDelete('set null');
            }
            
            // Tambahkan rombel_tujuan_id
            if (!Schema::hasColumn('mutasi_siswas', 'rombel_tujuan_id')) {
                $table->unsignedBigInteger('rombel_tujuan_id')->nullable()->after('rombel_asal_id');
                $table->foreign('rombel_tujuan_id')->references('id')->on('rombels')->onDelete('set null');
            }
            
            // Tambahkan diproses_oleh
            if (!Schema::hasColumn('mutasi_siswas', 'diproses_oleh')) {
                $table->unsignedBigInteger('diproses_oleh')->nullable()->after('tujuan_pindah');
                $table->foreign('diproses_oleh')->references('id')->on('users')->onDelete('set null');
            }
            
            // Tambahkan tahun_ajaran jika belum ada
            if (!Schema::hasColumn('mutasi_siswas', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable()->after('tanggal_mutasi');
            }
        });
    }

    public function down()
    {
        Schema::table('mutasi_siswas', function (Blueprint $table) {
            $table->dropForeign(['rombel_asal_id']);
            $table->dropForeign(['rombel_tujuan_id']);
            $table->dropForeign(['diproses_oleh']);
            
            $table->dropColumn(['rombel_asal_id', 'rombel_tujuan_id', 'diproses_oleh', 'tahun_ajaran']);
        });
    }
};