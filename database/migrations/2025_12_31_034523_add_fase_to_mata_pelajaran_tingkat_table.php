<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_pelajaran_tingkat', function (Blueprint $table) {
            $table->string('fase', 5)
                  ->nullable()
                  ->after('tingkat');
        });
    }

    public function down(): void
    {
        Schema::table('mata_pelajaran_tingkat', function (Blueprint $table) {
            $table->dropColumn('fase');
        });
    }
};
