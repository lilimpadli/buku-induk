php a<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jam', 10)->unique();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_pelajarans');
    }
};