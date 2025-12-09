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
    Schema::table('data_siswa', function (Blueprint $table) {
        $table->unsignedBigInteger('rombel_id')->nullable()->after('id');

        $table->foreign('rombel_id')
              ->references('id')
              ->on('rombels')
              ->nullOnDelete();
    });
}

public function down()
{
    Schema::table('data_siswa', function (Blueprint $table) {
        $table->dropForeign(['rombel_id']);
        $table->dropColumn('rombel_id');
    });
}


};
