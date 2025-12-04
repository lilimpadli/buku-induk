<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->string('nama');
            $table->enum('kelompok', ['A', 'B'])->default('A'); // Kelompok A/B
            $table->integer('urutan')->nullable(); // nomor di rapor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
