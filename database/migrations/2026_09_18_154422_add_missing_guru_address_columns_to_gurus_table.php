<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar kolom yang DIPAKAI controller/model Guru,
     * tapi BELUM ADA di tabel gurus (berdasarkan Schema::getColumnListing).
     * Semua nullable supaya data existing tidak error.
     */
    private array $columns = [
        'alamat_jalan',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kode_pos',
    ];

    public function up(): void
    {
        $missing = [];
        foreach ($this->columns as $column) {
            if (!Schema::hasColumn('gurus', $column)) {
                $missing[] = $column;
            }
        }

        if (empty($missing)) {
            // Semua kolom sudah ada — tidak ada yang perlu ditambah.
            return;
        }

        Schema::table('gurus', function (Blueprint $table) use ($missing) {
            foreach ($missing as $column) {
                $table->string($column, 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        $existing = [];
        foreach ($this->columns as $column) {
            if (Schema::hasColumn('gurus', $column)) {
                $existing[] = $column;
            }
        }

        if (empty($existing)) {
            return;
        }

        Schema::table('gurus', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};