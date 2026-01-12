<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            if (Schema::hasColumn('data_siswa', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            if (Schema::hasColumn('data_siswa', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable(false)->change();
            }
        });
    }
};
