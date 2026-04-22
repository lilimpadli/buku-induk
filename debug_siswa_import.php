<?php
require 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\DataSiswa;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek user siswa yang ada
echo "=== USER SISWA YANG ADA ===\n";
$users = User::where('role', 'siswa')->get();
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, NIS: {$user->nomor_induk}\n";
    
    // Cek apakah ada data_siswa
    $dataSiswa = DataSiswa::where('user_id', $user->id)->first();
    if ($dataSiswa) {
        echo "  ✓ Ada DataSiswa - ID: {$dataSiswa->id}, NIS: {$dataSiswa->nis}\n";
    } else {
        echo "  ✗ TIDAK ADA DataSiswa untuk user ini\n";
    }
}

echo "\n=== TOTAL DATA_SISWA ===\n";
$totalSiswa = DataSiswa::count();
echo "Total: {$totalSiswa}\n";

echo "\n=== COBA TEST IMPORT DARI TEMPLATE ===\n";
// Coba import dengan data sample
$import = new \App\Imports\SiswaImport();
$testData = [
    [
        'nis' => 'TEST001',
        'nisn' => '9999999999',
        'nama_lengkap' => 'Test Siswa',
        'jenis_kelamin' => 'Laki-laki',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2008-01-01',
        'kewarganegaraan' => 'Indonesia',
        'agama' => 'Islam',
        'rt' => '001',
        'rw' => '002',
        'dusun' => 'Test',
        'kelurahan' => 'Test',
        'kecamatan' => 'Test',
        'kode_pos' => '12345',
        'no_hp' => '',
        'sekolah_asal' => 'Test',
        'tanggal_diterima' => '2023-01-01',
        'nama_ayah' => 'Ayah Test',
        'pekerjaan_ayah' => 'Test',
        'nama_ibu' => 'Ibu Test',
        'pekerjaan_ibu' => 'Test',
        'nama_wali' => '-',
        'pekerjaan_wali' => '-',
        'alamat_rumah' => 'Test Address',
        'alamat_wali' => '-',
    ]
];

echo "Testing dengan data normalized...\n";
$result = $import->model($testData[0]);
$errors = $import->getErrors();
$success = $import->getSuccessCount();

echo "Success Count: {$success}\n";
if (count($errors) > 0) {
    echo "Errors:\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
} else {
    echo "No errors\n";
}

// Cek apakah data berhasil dibuat
$testSiswa = DataSiswa::where('nis', 'TEST001')->first();
if ($testSiswa) {
    echo "\n✓ Test data berhasil dibuat! ID: {$testSiswa->id}\n";
    echo "  User ID: {$testSiswa->user_id}\n";
    echo "  Nama: {$testSiswa->nama_lengkap}\n";
} else {
    echo "\n✗ Test data TIDAK berhasil dibuat\n";
}
