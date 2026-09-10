<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_pelajaran_tingkat', function (Blueprint $table) {
            if (!Schema::hasColumn('mata_pelajaran_tingkat', 'konsentrasi_id')) {
                $table->unsignedBigInteger('konsentrasi_id')->nullable()->after('tingkat');
                $table->foreign('konsentrasi_id')
                      ->references('id')
                      ->on('konsentrasi_keahlian')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mata_pelajaran_tingkat', function (Blueprint $table) {
            $table->dropForeign(['konsentrasi_id']);
            $table->dropColumn('konsentrasi_id');
        });
    }
};