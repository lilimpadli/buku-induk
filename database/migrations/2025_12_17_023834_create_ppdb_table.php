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
       Schema::create('ppdb', function (Blueprint $table) {
    $table->id();

    // =====================
    // DATA SISWA
    // =====================
    $table->string('nama_lengkap');
    $table->string('nisn', 20)->nullable()->unique();
    $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
    $table->string('tempat_lahir')->nullable();
    $table->date('tanggal_lahir')->nullable();
    $table->text('alamat')->nullable();

    // =====================
    // RELASI PPDB
    // =====================
    $table->foreignId('jalur_ppdb_id')
        ->constrained('jalur_ppdb')
        ->cascadeOnDelete();

    $table->foreignId('sesi_ppdb_id')
        ->constrained('sesi_ppdb')
        ->cascadeOnDelete();

    $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();
    $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
    $table->foreignId('rombel_id')->nullable()->constrained('rombels')->nullOnDelete();

    $table->string('tahun_ajaran')->nullable();
    $table->date('tanggal_diterima')->nullable();

    // =====================
    // DOKUMEN
    // =====================
    $table->string('foto')->nullable();
    $table->string('kk')->nullable();
    $table->string('akta')->nullable();
    $table->string('ijazah')->nullable();
    $table->string('bukti_jalur')->nullable();

    // =====================
    // STATUS
    // =====================
    $table->enum('status', ['diterima', 'aktif'])
        ->default('diterima');

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb');
    }
};
