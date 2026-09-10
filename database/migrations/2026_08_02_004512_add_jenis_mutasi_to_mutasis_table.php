<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            if (!Schema::hasColumn('mutasis', 'jenis_mutasi')) {
                $table->string('jenis_mutasi')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropColumn('jenis_mutasi');
        });
    }
};