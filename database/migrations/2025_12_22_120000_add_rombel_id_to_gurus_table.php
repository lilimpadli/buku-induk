<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            // tambahkan kolom rombel_id yang nullable dan constraint ke tabel rombels
            $table->foreignId('rombel_id')->nullable()->constrained('rombels')->nullOnDelete()->after('kelas_id');
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            // drop foreign key dan kolom
            if (Schema::hasColumn('gurus', 'rombel_id')) {
                $table->dropForeign(['rombel_id']);
                $table->dropColumn('rombel_id');
            }
        });
    }
};
