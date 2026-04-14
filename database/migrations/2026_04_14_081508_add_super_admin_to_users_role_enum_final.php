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
        // Tambahkan super_admin ke enum role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa', 'walikelas', 'kaprog', 'tu', 'kurikulum', 'calon_siswa', 'guru', 'tu_kepegawaian', 'super_admin') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus super_admin dari enum role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa', 'walikelas', 'kaprog', 'tu', 'kurikulum', 'calon_siswa', 'guru', 'tu_kepegawaian') NOT NULL");
    }
};
