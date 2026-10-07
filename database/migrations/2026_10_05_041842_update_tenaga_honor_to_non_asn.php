<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update semua variasi "Honor" jadi "Non-ASN"
        $variants = [
            'Tenaga Honor Sekolah',
            'Tenaga Honorer',
            'Honorer',
            'honorer',
            'Guru Honorer',
        ];

        foreach ($variants as $old) {
            DB::table('gurus')
                ->where('status_kepegawaian', $old)
                ->update(['status_kepegawaian' => 'Non-ASN']);

            DB::table('pegawais')
                ->where('status_kepegawaian', $old)
                ->update(['status_kepegawaian' => 'Non-ASN']);
        }
    }

    public function down(): void
    {
        DB::table('gurus')
            ->where('status_kepegawaian', 'Non-ASN')
            ->update(['status_kepegawaian' => 'Tenaga Honor Sekolah']);

        DB::table('pegawais')
            ->where('status_kepegawaian', 'Non-ASN')
            ->update(['status_kepegawaian' => 'Tenaga Honor Sekolah']);
    }
};