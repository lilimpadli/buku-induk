<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;   // ← WAJIB

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE kenaikan_kelas
            MODIFY status ENUM('Naik Kelas', 'Tidak Naik', 'Lulus') NULL
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE kenaikan_kelas
            MODIFY status VARCHAR(50) NULL
        ");
    }
};
