<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah field Dapodik ke tabel data_siswa.
     * Semua kolom nullable, jadi data lama TIDAK akan error.
     */
    public function up(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            // ================================
            // A. IDENTITAS TAMBAHAN (7)
            // ================================
            $table->string('nik', 20)->nullable()->after('nisn');
            $table->string('no_kk', 20)->nullable()->after('nik');
            $table->string('no_registrasi_akta', 50)->nullable()->after('no_kk');
            $table->string('kebutuhan_khusus', 50)->nullable()->after('no_registrasi_akta');
            $table->string('alat_transportasi', 50)->nullable()->after('kebutuhan_khusus');
            $table->string('jenis_tinggal', 50)->nullable()->after('alat_transportasi');
            $table->string('email', 100)->nullable()->after('no_hp');

            // ================================
            // B. DATA AYAH (4)
            // ================================
            $table->smallInteger('tahun_lahir_ayah')->nullable()->after('nama_ayah');
            $table->string('jenjang_pendidikan_ayah', 50)->nullable()->after('tahun_lahir_ayah');
            $table->string('penghasilan_ayah', 50)->nullable()->after('pekerjaan_ayah');
            $table->string('nik_ayah', 20)->nullable()->after('penghasilan_ayah');

            // ================================
            // C. DATA IBU (4)
            // ================================
            $table->smallInteger('tahun_lahir_ibu')->nullable()->after('nama_ibu');
            $table->string('jenjang_pendidikan_ibu', 50)->nullable()->after('tahun_lahir_ibu');
            $table->string('penghasilan_ibu', 50)->nullable()->after('pekerjaan_ibu');
            $table->string('nik_ibu', 20)->nullable()->after('penghasilan_ibu');

            // ================================
            // D. DATA WALI (4)
            // ================================
            $table->smallInteger('tahun_lahir_wali')->nullable()->after('nama_wali');
            $table->string('jenjang_pendidikan_wali', 50)->nullable()->after('tahun_lahir_wali');
            $table->string('penghasilan_wali', 50)->nullable()->after('pekerjaan_wali');
            $table->string('nik_wali', 20)->nullable()->after('penghasilan_wali');

            // ================================
            // E. KIP / KPS / PIP (6)
            // ================================
            $table->string('penerima_kps', 10)->nullable()->after('nik_wali');
            $table->string('no_kps', 50)->nullable()->after('penerima_kps');
            $table->string('penerima_kip', 10)->nullable()->after('no_kps');
            $table->string('nomor_kip', 50)->nullable()->after('penerima_kip');
            $table->string('nama_kip', 100)->nullable()->after('nomor_kip');
            $table->string('nomor_kks', 50)->nullable()->after('nama_kip');

            // ================================
            // F. BANK & PIP (5)
            // ================================
            $table->string('bank', 50)->nullable()->after('nomor_kks');
            $table->string('nomor_rekening', 50)->nullable()->after('bank');
            $table->string('rekening_atas_nama', 100)->nullable()->after('nomor_rekening');
            $table->string('layak_pip', 10)->nullable()->after('rekening_atas_nama');
            $table->string('alasan_layak_pip', 100)->nullable()->after('layak_pip');

            // ================================
            // G. UJIAN (3)
            // ================================
            $table->string('skhun', 50)->nullable()->after('alasan_layak_pip');
            $table->string('no_peserta_un', 50)->nullable()->after('skhun');
            $table->string('no_seri_ijazah', 50)->nullable()->after('ijazah_nomor');

            // ================================
            // H. FISIK & LOKASI (7)
            // ================================
            $table->decimal('berat_badan', 5, 2)->nullable()->after('no_seri_ijazah');
            $table->decimal('tinggi_badan', 5, 2)->nullable()->after('berat_badan');
            $table->decimal('lingkar_kepala', 5, 2)->nullable()->after('tinggi_badan');
            $table->tinyInteger('jumlah_saudara')->nullable()->after('lingkar_kepala');
            $table->decimal('jarak_rumah_sekolah', 8, 3)->nullable()->after('jumlah_saudara');
            $table->decimal('lintang', 10, 7)->nullable()->after('jarak_rumah_sekolah');
            $table->decimal('bujur', 10, 7)->nullable()->after('lintang');
        });
    }

    /**
     * Rollback: hapus kolom Dapodik.
     */
    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->dropColumn([
                // A
                'nik', 'no_kk', 'no_registrasi_akta', 'kebutuhan_khusus',
                'alat_transportasi', 'jenis_tinggal', 'email',
                // B
                'tahun_lahir_ayah', 'jenjang_pendidikan_ayah',
                'penghasilan_ayah', 'nik_ayah',
                // C
                'tahun_lahir_ibu', 'jenjang_pendidikan_ibu',
                'penghasilan_ibu', 'nik_ibu',
                // D
                'tahun_lahir_wali', 'jenjang_pendidikan_wali',
                'penghasilan_wali', 'nik_wali',
                // E
                'penerima_kps', 'no_kps', 'penerima_kip',
                'nomor_kip', 'nama_kip', 'nomor_kks',
                // F
                'bank', 'nomor_rekening', 'rekening_atas_nama',
                'layak_pip', 'alasan_layak_pip',
                // G
                'skhun', 'no_peserta_un', 'no_seri_ijazah',
                // H
                'berat_badan', 'tinggi_badan', 'lingkar_kepala',
                'jumlah_saudara', 'jarak_rumah_sekolah',
                'lintang', 'bujur',
            ]);
        });
    }
};