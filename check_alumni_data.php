<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/check.php';

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

use App\Models\DataSiswa;
use App\Models\NilaiRaport;
use App\Models\KenaikanKelas;

// Boot the application
$app->make('Illuminate\Contracts\Http\Kernel');

echo "=== CHECK ALUMNI DATA ===\n\n";

// Check siswa ID 1
$siswa = DataSiswa::find(1);
if ($siswa) {
    echo "Siswa ID 1: " . $siswa->nama_lengkap . "\n";
    
    // Check nilai
    $nilaiCount = NilaiRaport::where('siswa_id', 1)->count();
    echo "Nilai Count: " . $nilaiCount . "\n";
    
    if ($nilaiCount > 0) {
        $nilai = NilaiRaport::where('siswa_id', 1)->first();
        echo "  - Tahun: " . $nilai->tahun_ajaran . ", Semester: " . $nilai->semester . "\n";
    }
    
    // Check kenaikan kelas
    $kenaikanCount = KenaikanKelas::where('siswa_id', 1)->count();
    echo "Kenaikan Kelas Count: " . $kenaikanCount . "\n";
    
    if ($kenaikanCount > 0) {
        $kenaikan = KenaikanKelas::where('siswa_id', 1)->first();
        echo "  - Status: " . $kenaikan->status . ", Tahun: " . $kenaikan->tahun_ajaran . "\n";
    }
} else {
    echo "Siswa ID 1 tidak ditemukan\n";
}

echo "\n=== FIND ALUMNI WITH DATA ===\n";
$siswaWithNilai = NilaiRaport::distinct('siswa_id')->limit(5)->pluck('siswa_id');
echo "Siswa dengan nilai: " . $siswaWithNilai->count() . " siswa\n";

foreach ($siswaWithNilai as $id) {
    $s = DataSiswa::find($id);
    $n = NilaiRaport::where('siswa_id', $id)->count();
    echo "  - ID $id: " . ($s ? $s->nama_lengkap : 'Unknown') . " ($n nilai)\n";
}
