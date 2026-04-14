<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->foreignId('id_kurikulum')
                  ->nullable()
                  ->constrained('kurikum')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_kurikulum');
        });
    }
};
