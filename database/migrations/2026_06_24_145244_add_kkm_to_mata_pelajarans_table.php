<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            // KKM = Kriteria Ketuntasan Minimal
            $table->integer('kkm')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropColumn('kkm');
        });
    }
};