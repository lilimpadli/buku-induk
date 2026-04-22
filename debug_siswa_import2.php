<?php
require 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\DataSiswa;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Cek "Siswa Default"
echo "=== CEK USER 'SISWA DEFAULT' ===\n";
$siswaDef = User::where('name', 'Siswa Default')->first();
if ($siswaDef) {
    echo "ID: {$siswaDef->id}\n";
    echo "Nama: {$siswaDef->name}\n";
    echo "NIS: {$siswaDef->nomor_induk}\n";
    
    $dataSiswa = DataSiswa::where('user_id', $siswaDef->id)->first();
    if (!$dataSiswa) {
        echo "\n❌ TIDAK ADA DataSiswa untuk user ini\n";
        echo "\nMencoba membuat DataSiswa secara manual...\n";
        
        try {
            $new = DataSiswa::create([
                'user_id' => $siswaDef->id,
                'nama_lengkap' => $siswaDef->name,
                'nis' => $siswaDef->nomor_induk,
                'nisn' => '',
            ]);
            echo "✓ Berhasil membuat DataSiswa\n";
            echo "  ID: {$new->id}\n";
            echo "  NIS: {$new->nis}\n";
        } catch (\Exception $e) {
            echo "✗ Error: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "User 'Siswa Default' tidak ditemukan\n";
}

// Test Excel parsing
echo "\n=== TEST PARSING EXCEL DARI TEMPLATE ===\n";
$templatePath = storage_path('app/template_test.xlsx');

// Cek apakah file ada
if (file_exists($templatePath)) {
    echo "File template ditemukan: {$templatePath}\n";
    
    // Parse Excel menggunakan method yang sama dengan import
    $import = new \App\Imports\SiswaImport();
    
    try {
        Excel::import($import, $templatePath);
        echo "\nImport Results:\n";
        echo "Success Count: " . $import->getSuccessCount() . "\n";
        
        $errors = $import->getErrors();
        if (count($errors) > 0) {
            echo "Errors found: " . count($errors) . "\n";
            foreach (array_slice($errors, 0, 10) as $error) {
                echo "  - {$error}\n";
            }
        } else {
            echo "No errors\n";
        }
    } catch (\Exception $e) {
        echo "Error loading template: " . $e->getMessage() . "\n";
    }
} else {
    echo "File template tidak ditemukan di: {$templatePath}\n";
    echo "Buat file dengan download template dulu\n";
}

// Check recent log
echo "\n=== RECENT LOGS (storage/logs/) ===\n";
$logDir = storage_path('logs');
if (is_dir($logDir)) {
    $files = array_diff(scandir($logDir, SCANDIR_SORT_DESCENDING), ['.', '..']);
    foreach (array_slice($files, 0, 3) as $file) {
        $logFile = "{$logDir}/{$file}";
        if (is_file($logFile)) {
            echo "\nFile: {$file}\n";
            // Get last 30 lines
            $lines = file($logFile);
            $lastLines = array_slice($lines, -30);
            foreach ($lastLines as $line) {
                if (strpos($line, 'siswa') !== false || strpos($line, 'Siswa') !== false || strpos($line, 'import') !== false) {
                    echo trim($line) . "\n";
                }
            }
        }
    }
}
