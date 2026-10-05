<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel `mutasis` di DB hanya punya id + timestamps.
     * Padahal model `Mutasi` & view `mutasi.index` butuh:
     * guru_id, nama_entitas, jenis, tanggal, keterangan.
     *
     * Migration ini menambahkan kolom-kolom tersebut.
     * Semua nullable supaya aman.
     */
    public function up(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            if (!Schema::hasColumn('mutasis', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable();
            }
            if (!Schema::hasColumn('mutasis', 'nama_entitas')) {
                $table->string('nama_entitas', 150)->nullable();
            }
            if (!Schema::hasColumn('mutasis', 'jenis')) {
                $table->string('jenis', 50)->nullable();
            }
            if (!Schema::hasColumn('mutasis', 'tanggal')) {
                $table->date('tanggal')->nullable();
            }
            if (!Schema::hasColumn('mutasis', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }

    public function down(): void
    {
        $columns = ['guru_id', 'nama_entitas', 'jenis', 'tanggal', 'keterangan'];

        Schema::table('mutasis', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                if (Schema::hasColumn('mutasis', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};