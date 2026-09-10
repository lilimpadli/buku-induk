<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            // Hapus kolom yang tidak sesuai
            if (Schema::hasColumn('kenaikan_kelas', 'kelas_lama')) {
                $table->dropColumn('kelas_lama');
            }
            if (Schema::hasColumn('kenaikan_kelas', 'kelas_baru')) {
                $table->dropColumn('kelas_baru');
            }

            // Tambahkan kolom yang dibutuhkan
            if (!Schema::hasColumn('kenaikan_kelas', 'jurusan_id')) {
                $table->unsignedBigInteger('jurusan_id')->nullable()->after('siswa_id');
                $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('set null');
            }

            if (!Schema::hasColumn('kenaikan_kelas', 'kelas_tingkat')) {
                $table->string('kelas_tingkat')->nullable()->after('jurusan_id');
            }

            if (!Schema::hasColumn('kenaikan_kelas', 'semester')) {
                $table->string('semester')->nullable()->after('kelas_tingkat');
            }

            if (!Schema::hasColumn('kenaikan_kelas', 'rombel_tujuan_id')) {
                $table->unsignedBigInteger('rombel_tujuan_id')->nullable()->after('status');
                $table->foreign('rombel_tujuan_id')->references('id')->on('rombels')->onDelete('set null');
            }

            if (!Schema::hasColumn('kenaikan_kelas', 'diproses_oleh')) {
                $table->unsignedBigInteger('diproses_oleh')->nullable()->after('rombel_tujuan_id');
                $table->foreign('diproses_oleh')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('kenaikan_kelas', 'tanggal_diproses')) {
                $table->date('tanggal_diproses')->nullable()->after('diproses_oleh');
            }
        });
    }

    public function down()
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['rombel_tujuan_id']);
            $table->dropForeign(['diproses_oleh']);
            $table->dropColumn(['jurusan_id', 'kelas_tingkat', 'semester', 'rombel_tujuan_id', 'diproses_oleh', 'tanggal_diproses']);
        });
    }
};