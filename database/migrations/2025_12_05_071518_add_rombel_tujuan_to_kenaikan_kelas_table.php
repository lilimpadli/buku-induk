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
    Schema::table('kenaikan_kelas', function (Blueprint $table) {
        $table->unsignedBigInteger('rombel_tujuan_id')->nullable()->after('status');

        $table->foreign('rombel_tujuan_id')
              ->references('id')
              ->on('rombels')
              ->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('kenaikan_kelas', function (Blueprint $table) {
        $table->dropForeign(['rombel_tujuan_id']);
        $table->dropColumn('rombel_tujuan_id');
    });
}

};
