<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('kenaikan_kelas', 'diproses_oleh')) {
                $table->foreignId('diproses_oleh')->nullable()->after('rombel_tujuan_id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('kenaikan_kelas', 'tanggal_diproses')) {
                $table->date('tanggal_diproses')->nullable()->after('diproses_oleh');
            }
        });
    }

    public function down()
    {
        Schema::table('kenaikan_kelas', function (Blueprint $table) {
            $table->dropForeign(['diproses_oleh']);
            $table->dropColumn(['diproses_oleh', 'tanggal_diproses']);
        });
    }
};
