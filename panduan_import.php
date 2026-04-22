<?php
require 'vendor/autoload.php';

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\DataSiswa;

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PANDUAN IMPORT DATA SISWA ===\n\n";

echo "LANGKAH 1: Download Template\n";
echo "================================\n";
echo "1. Buka URL: http://127.0.0.1:8000/admin/siswa/download-template\n";
echo "2. File akan didownload dengan nama: Template_Import_Data_Diri_Siswa_YYYY-MM-DD.xlsx\n\n";

echo "LANGKAH 2: Periksa Struktur Template\n";
echo "====================================\n";
echo "Template harus memiliki header TEPAT seperti ini (di baris PERTAMA data):\n\n";

$headers = [
    'NIS', 'NISN', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 
    'Tanggal Lahir', 'Kewarganegaraan', 'Agama', 'RT', 'RW', 'Dusun', 
    'Kelurahan', 'Kecamatan', 'Kode Pos', 'Nama Ayah', 'Nama Ibu', 
    'Pekerjaan Ayah', 'Alamat Rumah', 'Nama Wali', 'Pekerjaan Wali', 
    'Alamat Wali', 'Mulai Tanggal Diterima', 'Asal Sekolah'
];

foreach ($headers as $idx => $h) {
    echo ($idx + 1) . ". {$h}\n";
}

echo "\n\nLANGKAH 3: Isi Data Siswa\n";
echo "========================\n";
echo "- Mulai dari baris KEDUA (baris 1 adalah header)\n";
echo "- Kolom NIS: Harus diisi (Nomor Induk Siswa)\n";
echo "- Kolom Nama Lengkap: Harus diisi\n";
echo "- Kolom Tanggal Lahir: Format YYYY-MM-DD atau DD-MM-YYYY\n";
echo "- Kolom Mulai Tanggal Diterima: Format YYYY-MM-DD atau DD-MM-YYYY\n";
echo "- Jika tidak ada data Wali: Isi dengan '-'\n\n";

echo "LANGKAH 4: Hapus Baris Contoh\n";
echo "=============================\n";
echo "- Template berisi 3 baris contoh (contoh data siswa)\n";
echo "- HAPUS SEMUA baris contoh sebelum upload\n";
echo "- Pastikan baris KEDUA adalah data REAL siswa Anda\n\n";

echo "LANGKAH 5: Upload File\n";
echo "====================\n";
echo "1. Buka URL: http://127.0.0.1:8000/admin/siswa/import\n";
echo "2. Pilih file Excel yang sudah diisi\n";
echo "3. Klik 'Import'\n\n";

// Cek data siswa yang perlu diupdate
echo "\nDATA SISWA YANG PERLU DIUPDATE:\n";
echo "==============================\n";
$usersWithoutData = User::where('role', 'siswa')
    ->whereNotIn('id', DataSiswa::pluck('user_id')->toArray())
    ->get();

if ($usersWithoutData->count() > 0) {
    echo "Ada " . $usersWithoutData->count() . " user siswa yang BELUM punya data:\n\n";
    foreach ($usersWithoutData as $user) {
        echo "- {$user->name} (NIS: {$user->nomor_induk})\n";
    }
    echo "\nAnda bisa menggunakan NIS di atas untuk mengisi file Excel\n";
} else {
    echo "Semua user siswa sudah memiliki data ✓\n";
}

echo "\n\nPERIKSA TEMPLATE YANG DIDOWNLOAD:\n";
echo "=================================\n";
echo "Buka file Excel di Microsoft Excel atau LibreOffice Calc\n";
echo "Pastikan:\n";
echo "✓ Baris 1-3 adalah instruksi (hapus sebelum submit)\n";
echo "✓ Baris 4 adalah HEADER dengan nama kolom tepat seperti di atas\n";
echo "✓ Baris 5+ adalah DATA (atau kosong)\n";
echo "✓ Jangan ada kolom tambahan atau kolom yang hilang\n";
