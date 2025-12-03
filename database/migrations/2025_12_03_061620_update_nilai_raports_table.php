<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_raports', function (Blueprint $table) {

            // Hapus KKM jika masih ada
            if (Schema::hasColumn('nilai_raports', 'kkm')) {
                $table->dropColumn('kkm');
            }

            // Tambah kolom pengetahuan
            if (!Schema::hasColumn('nilai_raports', 'nilai_pengetahuan')) {
                $table->integer('nilai_pengetahuan')->default(0);
            }
            if (!Schema::hasColumn('nilai_raports', 'predikat_pengetahuan')) {
                $table->string('predikat_pengetahuan')->nullable();
            }
            if (!Schema::hasColumn('nilai_raports', 'deskripsi_pengetahuan')) {
                $table->text('deskripsi_pengetahuan')->nullable();
            }

            // Tambah kolom keterampilan
            if (!Schema::hasColumn('nilai_raports', 'nilai_keterampilan')) {
                $table->integer('nilai_keterampilan')->default(0);
            }
            if (!Schema::hasColumn('nilai_raports', 'predikat_keterampilan')) {
                $table->string('predikat_keterampilan')->nullable();
            }
            if (!Schema::hasColumn('nilai_raports', 'deskripsi_keterampilan')) {
                $table->text('deskripsi_keterampilan')->nullable();
            }

        });
    }

    public function down()
    {
        Schema::table('nilai_raports', function (Blueprint $table) {

            // Restore KKM
            if (!Schema::hasColumn('nilai_raports', 'kkm')) {
                $table->integer('kkm')->nullable();
            }

            // Drop kolom pengetahuan
            if (Schema::hasColumn('nilai_raports', 'nilai_pengetahuan')) {
                $table->dropColumn('nilai_pengetahuan');
            }
            if (Schema::hasColumn('nilai_raports', 'predikat_pengetahuan')) {
                $table->dropColumn('predikat_pengetahuan');
            }
            if (Schema::hasColumn('nilai_raports', 'deskripsi_pengetahuan')) {
                $table->dropColumn('deskripsi_pengetahuan');
            }

            // Drop kolom keterampilan
            if (Schema::hasColumn('nilai_raports', 'nilai_keterampilan')) {
                $table->dropColumn('nilai_keterampilan');
            }
            if (Schema::hasColumn('nilai_raports', 'predikat_keterampilan')) {
                $table->dropColumn('predikat_keterampilan');
            }
            if (Schema::hasColumn('nilai_raports', 'deskripsi_keterampilan')) {
                $table->dropColumn('deskripsi_keterampilan');
            }

        });
    }
};
