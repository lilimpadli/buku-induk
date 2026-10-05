<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$checks = [
    ['App\Models\Guru', 'gurus'],
    ['App\Models\Pegawai', 'pegawais'],
    ['App\Models\Mutasi', 'mutasis'],
    ['App\Models\MutasiPegawai', 'mutasi_pegawais'],
    ['App\Models\RiwayatKerja', 'riwayat_kerjas'],
    ['App\Models\RiwayatTugas', 'riwayat_tugas'],
    ['App\Models\TugasTambahan', 'tugas_tambahans'],
    ['App\Models\Dokumen', 'dokumens'],
    ['App\Models\Kurikulum', 'kurikulums'],
    ['App\Models\MataPelajaran', 'mata_pelajarans'],
    ['App\Models\DokumenMutasi', 'dokumen_mutasis'],
    ['App\Models\User', 'users'],
    ['App\Models\Jurusan', 'jurusans'],
    ['App\Models\Kelas', 'kelas'],
    ['App\Models\Rombel', 'rombels'],
];

foreach ($checks as [$class, $table]) {
    if (!class_exists($class)) {
        echo "[SKIP] $class — class tidak ada\n";
        continue;
    }
    if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
        echo "[NO TABLE] $table\n";
        continue;
    }

    $model = new $class;
    $fillable = $model->getFillable();
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
    $missing = array_diff($fillable, $columns);

    echo "=== $class -> $table ===\n";
    if (empty($missing)) {
        echo "  OK\n";
    } else {
        echo "  MISSING: " . implode(', ', $missing) . "\n";
    }
}

echo "\nSelesai.\n";