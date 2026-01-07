<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasColumn('sesi_ppdb', 'stage')) {
            Schema::table('sesi_ppdb', function (Blueprint $table) {
                $table->string('stage')->nullable()->after('nama_sesi')->comment('tahap1|tahap2');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('sesi_ppdb', 'stage')) {
            Schema::table('sesi_ppdb', function (Blueprint $table) {
                $table->dropColumn('stage');
            });
        }
    }
};
