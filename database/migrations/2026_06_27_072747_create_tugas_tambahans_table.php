<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    if (!Schema::hasTable('tugas_tambahans')) {
        Schema::create('tugas_tambahans', function (Blueprint $table) {
            $table->id();
            $table->string('entitas_type');
            $table->unsignedBigInteger('entitas_id');
            $table->string('nama_tugas');
            $table->string('sk_tugas')->nullable();
            $table->timestamps();
        });
    }
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_tambahans');
    }
};
