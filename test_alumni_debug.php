<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\KenaikanKelas;
use App\Models\DataSiswa;

echo "=== ALUMNI DATA DEBUG ===\n\n";

// Check KenaikanKelas dengan status 'lulus'
$count = KenaikanKelas::where('status', 'lulus')->count();
echo "Total KenaikanKelas dengan status 'lulus': " . $count . "\n";

if ($count > 0) {
    $data = KenaikanKelas::where('status', 'lulus')->with('siswa')->first();
    echo "\nSample data:\n";
    echo "ID: " . $data->id . "\n";
    echo "Tahun Ajaran: " . $data->tahun_ajaran . "\n";
    echo "Status: " . $data->status . "\n";
    echo "Siswa ID: " . $data->siswa_id . "\n";
    echo "Rombel ID: " . $data->rombel_id . "\n";
    echo "Rombel Tujuan ID: " . $data->rombel_tujuan_id . "\n";
    echo "Siswa Nama: " . ($data->siswa->nama_lengkap ?? 'N/A') . "\n";
    
    // Check rombel and kelas
    $siswa = $data->siswa;
    $rombel = $data->rombelTujuan ?? $siswa->rombel;
    if ($rombel) {
        echo "\nRombel info:\n";
        echo "Rombel ID: " . $rombel->id . "\n";
        echo "Rombel Nama: " . $rombel->nama . "\n";
        echo "Kelas ID: " . ($rombel->kelas_id ?? 'N/A') . "\n";
        
        if ($rombel->kelas) {
            echo "\nKelas info:\n";
            echo "Kelas Tingkat: " . $rombel->kelas->tingkat . "\n";
            echo "Jurusan ID: " . ($rombel->kelas->jurusan_id ?? 'N/A') . "\n";
            if ($rombel->kelas->jurusan) {
                echo "Jurusan Nama: " . $rombel->kelas->jurusan->nama . "\n";
            }
        }
    }
} else {
    echo "No alumni records found!\n";
}
?>
