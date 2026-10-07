<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('status_keaktifan')->nullable()->after('status_kepegawaian');
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn('status_keaktifan');
        });
    }
};