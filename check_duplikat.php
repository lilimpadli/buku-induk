<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== NILAI RAPORT SISWA 1672 - CEK DUPLIKASI ===\n";
$siswa = \App\Models\Siswa::find(1672);
if($siswa) {
    $nilai = $siswa->nilaiRaports()
        ->with('mapel')
        ->orderBy('tahun_ajaran')
        ->orderBy('semester')
        ->get();
    
    $byMapelNama = [];
    foreach($nilai as $n) {
        $nama = $n->mapel->nama;
        if(!isset($byMapelNama[$nama])) {
            $byMapelNama[$nama] = [];
        }
        $byMapelNama[$nama][] = [
            'id' => $n->mapel->id,
            'kelompok' => trim($n->mapel->kelompok ?? 'NULL'),
            'urutan' => $n->mapel->urutan,
            'tahun' => $n->tahun_ajaran,
            'sem' => $n->semester
        ];
    }
    
    foreach($byMapelNama as $nama => $data) {
        $unique = [];
        foreach($data as $d) {
            $key = $d['id'] . '-' . $d['kelompok'];
            if(!in_array($key, $unique)) {
                $unique[] = $key;
                echo "$nama: ID={$d['id']}, Kelompok={$d['kelompok']}, Urutan={$d['urutan']}\n";
            }
        }
    }
}
