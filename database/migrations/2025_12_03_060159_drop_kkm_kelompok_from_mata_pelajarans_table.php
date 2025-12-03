<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropColumn(['kkm', 'kelompok']);
        });
    }

    public function down()
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->integer('kkm')->nullable();
            $table->string('kelompok')->nullable();
        });
    }
};
