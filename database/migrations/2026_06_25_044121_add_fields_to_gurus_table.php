<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (! Schema::hasColumn('gurus', 'status_kepegawaian')) {
                $table->string('status_kepegawaian')->nullable();
            }
            if (! Schema::hasColumn('gurus', 'pendidikan')) {
                $table->string('pendidikan')->nullable();
            }
            if (! Schema::hasColumn('gurus', 'gelar_depan')) {
                $table->string('gelar_depan')->nullable();
            }
            if (! Schema::hasColumn('gurus', 'gelar_belakang')) {
                $table->string('gelar_belakang')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $columns = [];
            foreach (['status_kepegawaian', 'pendidikan', 'gelar_depan', 'gelar_belakang'] as $column) {
                if (Schema::hasColumn('gurus', $column)) {
                    $columns[] = $column;
                }
            }
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
