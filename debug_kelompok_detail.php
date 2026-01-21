<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== NILAI RAPORT SISWA 1672 - DETAIL KELOMPOK ===\n";
$siswa = \App\Models\Siswa::find(1672);
if($siswa) {
    $nilai = $siswa->nilaiRaports()
        ->with('mapel')
        ->orderBy('tahun_ajaran')
        ->orderBy('semester')
        ->get();
    
    foreach($nilai->groupBy('tahun_ajaran') as $tahun => $nilaiTahun) {
        echo "\n--- TAHUN $tahun ---\n";
        $byKel = [];
        foreach($nilaiTahun as $n) {
            $kel = trim($n->mapel->kelompok ?? 'NULL');
            $nama = trim($n->mapel->nama);
            if(!isset($byKel[$kel])) $byKel[$kel] = [];
            $byKel[$kel][] = [
                'id' => $n->mata_pelajaran_id,
                'nama' => $nama,
                'kelompok' => $kel
            ];
        }
        
        foreach(['A', 'B'] as $k) {
            if(isset($byKel[$k])) {
                echo "  KELOMPOK $k:\n";
                $unique = [];
                foreach($byKel[$k] as $item) {
                    $key = $item['nama'];
                    if(!isset($unique[$key])) {
                        $unique[$key] = $item['id'];
                        echo "    ID={$item['id']}: {$item['nama']}\n";
                    }
                }
            }
        }
    }
}
