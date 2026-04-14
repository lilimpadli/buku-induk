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
        // Ubah enum menjadi string untuk fleksibilitas
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke enum jika diperlukan
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa', 'walikelas', 'kaprog', 'tu', 'kurikulum', 'calon_siswa') NOT NULL");
    }
};
