<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('ekstrakurikuler_siswa', function (Blueprint $table) {
        $table->string('semester')->nullable()->after('siswa_id');
        $table->string('tahun_ajaran')->nullable()->after('semester');
    });
}

public function down()
{
    Schema::table('ekstrakurikuler_siswa', function (Blueprint $table) {
        $table->dropColumn('semester');
        $table->dropColumn('tahun_ajaran');
    });
}

};
