<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nilai_raports', function (Blueprint $table) {

            // pastikan kolom belum ada (AMAN jika dijalankan ulang)
            if (!Schema::hasColumn('nilai_raports', 'kelas_id')) {
                $table->foreignId('kelas_id')
                    ->nullable()
                    ->after('tahun_ajaran')
                    ->constrained('kelas')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('nilai_raports', 'rombel_id')) {
                $table->foreignId('rombel_id')
                    ->nullable()
                    ->after('kelas_id')
                    ->constrained('rombels')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('nilai_raports', function (Blueprint $table) {

            if (Schema::hasColumn('nilai_raports', 'rombel_id')) {
                $table->dropForeign(['rombel_id']);
                $table->dropColumn('rombel_id');
            }

            if (Schema::hasColumn('nilai_raports', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }
        });
    }
};
