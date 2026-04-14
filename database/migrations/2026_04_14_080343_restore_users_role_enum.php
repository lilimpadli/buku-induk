<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kembalikan ke enum dengan semua role yang ada
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa', 'walikelas', 'kaprog', 'tu', 'kurikulum', 'calon_siswa', 'guru', 'tu_kepegawaian') NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke VARCHAR jika diperlukan rollback
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL");
    }
};
