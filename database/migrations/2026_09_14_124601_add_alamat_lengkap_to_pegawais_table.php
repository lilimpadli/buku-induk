<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawais', 'rt')) {
                $table->string('rt', 10)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('pegawais', 'rw')) {
                $table->string('rw', 10)->nullable()->after('rt');
            }
            if (!Schema::hasColumn('pegawais', 'dusun')) {
                $table->string('dusun', 100)->nullable()->after('rw');
            }
            if (!Schema::hasColumn('pegawais', 'desa')) {
                $table->string('desa', 100)->nullable()->after('dusun');
            }
            if (!Schema::hasColumn('pegawais', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable()->after('desa');
            }
            if (!Schema::hasColumn('pegawais', 'kode_pos')) {
                $table->string('kode_pos', 10)->nullable()->after('kecamatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kode_pos']);
        });
    }
};