<?php
/**
 * Debug script untuk cek mapping mata pelajaran per jurusan dan tingkat
 * Jalankan: php debug_mata_pelajaran.php
 */

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MataPelajaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;

// Get all kelas (grouping by jurusan)
$kelases = Kelas::with('jurusan', 'rombels')->get();

$jurusans = $kelases->groupBy('jurusan.id')->map(function($items) {
    return [
        'jurusan' => $items->first()->jurusan,
        'kelases' => $items
    ];
});

foreach ($jurusans as $jurusanData) {
    $jurusan = $jurusanData['jurusan'];
    $kelases = $jurusanData['kelases'];
    
    echo "\n=== JURUSAN: {$jurusan->nama} (ID: {$jurusan->id}) ===\n";
    
    foreach ($kelases as $kelas) {
        echo "\n  Kelas: {$kelas->nama} - Tingkat: {$kelas->tingkat}\n";
        
        // Get rombels di kelas ini
        $rombels = $kelas->rombels;
        
        foreach ($rombels as $rombel) {
            echo "    Rombel: {$rombel->nama}\n";
            
            $tingkat = (string) $kelas->tingkat;
            
            // Query mata pelajaran yang seharusnya ada
            $mapelA = MataPelajaran::where('kelompok', 'A')
                ->whereHas('tingkats', function($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                })
                ->where(function($q) use ($jurusan) {
                    $q->whereDoesntHave('jurusans')
                      ->orWhereHas('jurusans', function($jq) use ($jurusan) {
                          $jq->where('jurusan_id', $jurusan->id);
                      });
                })
                ->distinct()
                ->get();
            
            echo "      Mapel A (" . count($mapelA) . "): ";
            echo implode(", ", $mapelA->pluck('nama')->toArray()) . "\n";
            
            $mapelB = MataPelajaran::where('kelompok', 'B')
                ->whereHas('tingkats', function($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                })
                ->where(function($q) use ($jurusan) {
                    $q->whereDoesntHave('jurusans')
                      ->orWhereHas('jurusans', function($jq) use ($jurusan) {
                          $jq->where('jurusan_id', $jurusan->id);
                      });
                })
                ->distinct()
                ->get();
            
            echo "      Mapel B (" . count($mapelB) . "): ";
            echo implode(", ", $mapelB->pluck('nama')->toArray()) . "\n";
        }
    }
}
