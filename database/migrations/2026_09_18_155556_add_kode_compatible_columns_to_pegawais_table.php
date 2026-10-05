<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom yang DIPAKAI kode (model Pegawai, TUKepegawaianController)
     * tapi BELUM ADA di tabel pegawais.
     *
     * Kondisi DB saat ini (dari Schema::getColumnListing):
     * - Punya: nama_lengkap, nip_nuptk, jk, tgl_lahir, mapel, foto, is_active, dll (versi lama)
     * - Hilang: nama, nip, nuptk, jenis_kelamin, tanggal_lahir, email,
     *           pendidikan, tugas_tambahan, user_id (versi baru)
     *
     * Semua kolom baru dibuat nullable supaya data existing tidak error.
     * Kolom lama TIDAK dihapus supaya tidak ada data hilang.
     */
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawais', 'nama')) {
                $table->string('nama', 100)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'nip')) {
                $table->string('nip', 30)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'nuptk')) {
                $table->string('nuptk', 30)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 10)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'email')) {
                $table->string('email', 100)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'pendidikan')) {
                $table->string('pendidikan', 50)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'tugas_tambahan')) {
                $table->string('tugas_tambahan', 100)->nullable();
            }
            if (!Schema::hasColumn('pegawais', 'user_id')) {
                // unsignedBigInteger agar cocok dengan users.id
                // (tanpa foreign key constraint supaya tidak error kalau data existing tidak match)
                $table->unsignedBigInteger('user_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        $columns = [
            'nama', 'nip', 'nuptk', 'jenis_kelamin',
            'tanggal_lahir', 'email', 'pendidikan',
            'tugas_tambahan', 'user_id',
        ];

        Schema::table('pegawais', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                if (Schema::hasColumn('pegawais', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};