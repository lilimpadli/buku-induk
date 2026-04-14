<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot table untuk mata_pelajaran dan kurikulum (many-to-many)
        Schema::create('kurikulum_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id')->constrained('kurikum')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['kurikulum_id', 'mata_pelajaran_id']);
        });

        // Pivot table untuk mata_pelajaran dan jurusan (many-to-many)
        Schema::create('jurusan_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['jurusan_id', 'mata_pelajaran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan_mata_pelajaran');
        Schema::dropIfExists('kurikulum_mata_pelajaran');
    }
};
