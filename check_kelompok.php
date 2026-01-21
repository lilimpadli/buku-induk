<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$mapel = \App\Models\MataPelajaran::select('id', 'nama', 'kelompok')->orderBy('kelompok')->orderBy('nama')->get();
echo "=== DAFTAR MATA PELAJARAN ===\n";
foreach($mapel as $m) {
    echo "{$m->id}. {$m->nama} -> [" . ($m->kelompok ?? 'NULL') . "]\n";
}

echo "\n=== NILAI RAPORT SISWA 1672 ===\n";
$siswa = \App\Models\Siswa::find(1672);
if($siswa) {
    $nilai = $siswa->nilaiRaports()->with('mapel')->get();
    foreach($nilai->groupBy('tahun_ajaran') as $tahun => $nilaiTahun) {
        echo "\nTahun: $tahun\n";
        foreach($nilaiTahun as $n) {
            echo "  {$n->mapel->nama} (kelompok: {$n->mapel->kelompok}) -> Sem {$n->semester}: {$n->nilai_akhir}\n";
        }
    }
}
