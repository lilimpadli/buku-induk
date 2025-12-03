<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_raports', function (Blueprint $table) {

            if (Schema::hasColumn('nilai_raports', 'nilai_keterampilan')) {
                $table->dropColumn('nilai_keterampilan');
            }

            if (Schema::hasColumn('nilai_raports', 'predikat_pengetahuan')) {
                $table->dropColumn('predikat_pengetahuan');
            }

            if (Schema::hasColumn('nilai_raports', 'predikat_keterampilan')) {
                $table->dropColumn('predikat_keterampilan');
            }

            if (Schema::hasColumn('nilai_raports', 'deskripsi_keterampilan')) {
                $table->dropColumn('deskripsi_keterampilan');
            }
        });
    }

    public function down()
    {
        Schema::table('nilai_raports', function (Blueprint $table) {
            $table->integer('nilai_keterampilan')->nullable();
            $table->string('predikat_pengetahuan')->nullable();
            $table->string('predikat_keterampilan')->nullable();
            $table->text('deskripsi_keterampilan')->nullable();
        });
    }
};
