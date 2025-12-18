<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('rombels', function (Blueprint $table) {
        // pastikan kolom nullable
        $table->unsignedBigInteger('guru_id')->nullable()->change();
    });

    // bersihkan data lama yang tidak valid
    DB::table('rombels')
        ->whereNotNull('guru_id')
        ->whereNotIn('guru_id', function ($q) {
            $q->select('id')->from('gurus');
        })
        ->update(['guru_id' => null]);

    Schema::table('rombels', function (Blueprint $table) {
        $table->foreign('guru_id')
              ->references('id')
              ->on('gurus')
              ->onDelete('set null');
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
