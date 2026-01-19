<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Note: changing column nullability requires doctrine/dbal package.
     */
    public function up()
    {
        if (Schema::hasTable('data_siswa')) {
            Schema::table('data_siswa', function (Blueprint $table) {
                // make tanggal_lahir nullable to allow imports without a date
                $table->date('tanggal_lahir')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('data_siswa')) {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->date('tanggal_lahir')->nullable(false)->change();
            });
        }
    }
};
