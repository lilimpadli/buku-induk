<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agamas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->unique();
            $table->timestamps();
        });

        DB::table('agamas')->insert([
            ['nama' => 'Islam', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kristen', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Katolik', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Hindu', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Buddha', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Konghucu', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('agamas');
    }
};
