<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== NILAI RAPORT SISWA 1672 DENGAN KELOMPOK ===\n";
$siswa = \App\Models\Siswa::find(1672);
if($siswa) {
    $nilai = $siswa->nilaiRaports()
        ->with('mapel')
        ->orderBy('tahun_ajaran')
        ->orderBy('semester')
        ->orderBy('mata_pelajaran_id')
        ->get();
    
    foreach($nilai->groupBy('tahun_ajaran') as $tahun => $nilaiTahun) {
        echo "\n--- TAHUN $tahun ---\n";
        $byKel = [];
        foreach($nilaiTahun as $n) {
            $kel = trim($n->mapel->kelompok ?? 'NULL');
            if(!isset($byKel[$kel])) $byKel[$kel] = [];
            $byKel[$kel][] = $n->mapel->nama;
        }
        
        foreach(['A', 'B'] as $k) {
            if(isset($byKel[$k])) {
                echo "  KELOMPOK $k:\n";
                $unique = array_unique($byKel[$k]);
                foreach($unique as $nama) {
                    echo "    - $nama\n";
                }
            }
        }
    }
}
