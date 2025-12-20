<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('data_siswa', function (Blueprint $table) {
        $table->string('tempat_lahir')->nullable()->change();
        // Tambahkan kolom lain yang perlu diubah jadi nullable
        $table->string('jenis_kelamin')->nullable()->change();
        $table->text('alamat')->nullable()->change();
    });
}

public function down()
{
    Schema::table('data_siswa', function (Blueprint $table) {
        $table->string('tempat_lahir')->nullable(false)->change();
        // Kembalikan perubahan
        $table->string('jenis_kelamin')->nullable(false)->change();
        $table->text('alamat')->nullable(false)->change();
    });
}
};
