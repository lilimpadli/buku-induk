<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            // Jenis entitas — Guru / Pegawai
            $table->string('tipe_entitas', 20)->nullable()->after('guru_id');

            // Identitas
            $table->string('nip', 50)->nullable()->after('nama_entitas');
            $table->string('nik', 30)->nullable()->after('nip');
            $table->string('nuptk', 50)->nullable()->after('nik');
            $table->string('jenis_kelamin', 5)->nullable()->after('nuptk');
            $table->string('tempat_lahir', 100)->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');

            // Kepegawaian
            $table->string('status_kepegawaian', 50)->nullable()->after('tanggal_lahir');
            $table->string('pendidikan', 100)->nullable()->after('status_kepegawaian');
            $table->string('serdik', 100)->nullable()->after('pendidikan');
            $table->string('tugas_tambahan', 255)->nullable()->after('serdik');
            $table->string('jabatan', 50)->nullable()->after('tugas_tambahan');

            // Kontak
            $table->string('email', 100)->nullable()->after('jabatan');
            $table->string('email_pribadi', 100)->nullable()->after('email');
            $table->string('email_resmi', 100)->nullable()->after('email_pribadi');
            $table->string('telepon', 30)->nullable()->after('email_resmi');

            // Alamat
            $table->text('alamat')->nullable()->after('telepon');
            $table->string('alamat_jalan', 255)->nullable()->after('alamat');
            $table->string('rt', 10)->nullable()->after('alamat_jalan');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('dusun', 100)->nullable()->after('rw');
            $table->string('desa', 100)->nullable()->after('dusun');
            $table->string('kecamatan', 100)->nullable()->after('desa');
            $table->string('kode_pos', 10)->nullable()->after('kecamatan');

            // User backup
            $table->unsignedBigInteger('user_id_backup')->nullable()->after('kode_pos');
        });
    }

    public function down(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_entitas',
                'nip', 'nik', 'nuptk', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
                'status_kepegawaian', 'pendidikan', 'serdik', 'tugas_tambahan', 'jabatan',
                'email', 'email_pribadi', 'email_resmi', 'telepon',
                'alamat', 'alamat_jalan', 'rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kode_pos',
                'user_id_backup',
            ]);
        });
    }
};