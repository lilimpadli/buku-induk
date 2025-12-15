<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rombels', function (Blueprint $table) {

            // rename kolom jika masih pakai wali_kelas_id
            if (Schema::hasColumn('rombels', 'wali_kelas_id')) {
                $table->renameColumn('wali_kelas_id', 'guru_id');
            }
        });

        Schema::table('rombels', function (Blueprint $table) {

            // pastikan kolom nullable
            $table->unsignedBigInteger('guru_id')->nullable()->change();

            // tambah foreign key ke gurus
            $table->foreign('guru_id')
                  ->references('id')
                  ->on('gurus')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rombels', function (Blueprint $table) {

            $table->dropForeign(['guru_id']);

            $table->renameColumn('guru_id', 'wali_kelas_id');

            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }
};
