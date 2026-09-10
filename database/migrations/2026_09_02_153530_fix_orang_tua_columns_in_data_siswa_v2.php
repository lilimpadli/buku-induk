<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // ============================================================
        // STEP 1: HAPUS FOREIGN KEY CONSTRAINTS
        // ============================================================
        try {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->dropForeign(['nama_ayah']);
            });
        } catch (\Exception $e) {
            // Abaikan error jika foreign key tidak ada
        }

        try {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->dropForeign(['nama_ibu']);
            });
        } catch (\Exception $e) {
            // Abaikan error jika foreign key tidak ada
        }

        try {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->dropForeign(['nama_wali']);
            });
        } catch (\Exception $e) {
            // Abaikan error jika foreign key tidak ada
        }

        // ============================================================
        // STEP 2: UBAH TIPE KOLOM (bigint → varchar)
        // ============================================================
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->string('nama_ayah', 255)->nullable()->change();
            $table->string('nama_ibu', 255)->nullable()->change();
            $table->string('nama_wali', 255)->nullable()->change();
        });

        // ============================================================
        // STEP 3: TAMBAHKAN KOLOM BARU (jika belum ada)
        // ============================================================
        Schema::table('data_siswa', function (Blueprint $table) {
            // Ayah
            if (!Schema::hasColumn('data_siswa', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'telepon_ayah')) {
                $table->string('telepon_ayah', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'alamat_ayah')) {
                $table->text('alamat_ayah')->nullable();
            }

            // Ibu
            if (!Schema::hasColumn('data_siswa', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'telepon_ibu')) {
                $table->string('telepon_ibu', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'alamat_ibu')) {
                $table->text('alamat_ibu')->nullable();
            }

            // Wali
            if (!Schema::hasColumn('data_siswa', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'telepon_wali')) {
                $table->string('telepon_wali', 255)->nullable();
            }
            if (!Schema::hasColumn('data_siswa', 'alamat_wali')) {
                $table->text('alamat_wali')->nullable();
            }
        });

        // ============================================================
        // STEP 4: HAPUS INDEX (jika masih ada)
        // ============================================================
        try {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->dropIndex(['nama_ayah']);
                $table->dropIndex(['nama_ibu']);
                $table->dropIndex(['nama_wali']);
            });
        } catch (\Exception $e) {
            // Abaikan error jika index tidak ada
        }

        // ============================================================
        // STEP 5: (OPSIONAL) HAPUS TABEL AYAHS DAN IBUS
        // ============================================================
        // Karena sudah tidak terpakai (Opsi 2: biarkan saja)
        // Jika ingin dihapus (Opsi 1), uncomment kode di bawah:
        // Schema::dropIfExists('ayahs');
        // Schema::dropIfExists('ibus');
    }

    public function down()
    {
        // Rollback: kembalikan ke bigint unsigned
        try {
            Schema::table('data_siswa', function (Blueprint $table) {
                $table->bigInteger('nama_ayah')->unsigned()->nullable()->change();
                $table->bigInteger('nama_ibu')->unsigned()->nullable()->change();
                $table->bigInteger('nama_wali')->unsigned()->nullable()->change();
            });
        } catch (\Exception $e) {
            // Abaikan error
        }
    }
};