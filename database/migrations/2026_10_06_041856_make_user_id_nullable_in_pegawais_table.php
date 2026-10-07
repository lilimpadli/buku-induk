<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // Drop foreign key dulu (kalau ada)
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Kalau gak ada FK, lanjut saja
            }
        });

        Schema::table('pegawais', function (Blueprint $table) {
            // Ubah kolom jadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};