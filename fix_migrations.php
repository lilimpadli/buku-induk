<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Daftar migrasi yang Pending
$migrations = [
    '2026_06_25_033848_add_status_kepegawaian_to_gurus_table',
    '2026_06_25_034137_add_status_to_gurus_table',
    '2026_06_25_044121_add_fields_to_gurus_table',
    '2026_06_26_000001_create_riwayat_kerjas_table_if_missing',
    '2026_06_27_020000_update_jenis_enum_mutasi_pegawais_table',
    '2026_06_27_072712_update_guru_and_pegawai_tables',
    '2026_06_27_072747_create_tugas_tambahans_table',
    '2026_06_27_072827_create_mutasis_table',
    '2026_06_27_104426_create_dokumen_mutasis_table',
    '2026_06_27_150000_create_penugasans_table',
    '2026_07_02_053647_add_pegawai_id_to_riwayat_tugas_table',
    '2026_07_02_055815_add_guru_details_to_gurus_table',
    '2026_08_02_004512_add_jenis_mutasi_to_mutasis_table',
    '2026_08_04_075428_add_missing_columns_to_gurus_table',
    '2026_08_06_145205_add_rombel_fields_to_mutasi_siswas',
    '2026_08_21_154928_create_nomor_surats_table',
    '2026_08_21_192707_add_jurusan_fields_to_kenaikan_kelas',
    '2026_08_24_171525_fix_kenaikan_kelas_fields',
    '2026_08_27_144440_fix_kenaikan_kelas_structure',
    '2026_08_27_144502_add_columns_to_mutasi_siswas',
    '2026_08_27_145231_add_missing_columns_to_mutasi_siswas',
    '2026_08_31_152715_add_konsentrasi_id_to_mata_pelajaran_tingkat',
    '2026_08_31_192136_rename_ayah_id_to_nama_ayah_in_data_siswa',
    '2026_08_31_192431_rename_ayah_ibu_wali_id_to_name_in_data_siswa',
    '2026_09_02_153530_fix_orang_tua_columns_in_data_siswa_v2',
];

$maxBatch = DB::table('migrations')->max('batch') + 1;
$inserted = 0;

foreach ($migrations as $migration) {
    $exists = DB::table('migrations')->where('migration', $migration)->exists();
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => $maxBatch,
        ]);
        $inserted++;
        echo "[INSERT] $migration\n";
    } else {
        echo "[SKIP] $migration (already exists)\n";
    }
}

echo "\n✅ Total inserted: $inserted\n";
echo "✅ All pending migrations marked as 'Ran'\n";\