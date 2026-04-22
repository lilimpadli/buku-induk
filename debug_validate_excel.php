<?php
require 'vendor/autoload.php';

use Maatwebsite\Excel\Facades\Excel;

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VALIDATOR FILE IMPORT SISWA ===\n\n";

// Cari file Excel terbaru yang diupload
$uploadDir = storage_path('app/imports');
$filePattern = 'Template_Import_Data_Diri_Siswa*';

// Gunakan file yang diberikan sebagai argument
$filePath = null;
if (isset($argv[1])) {
    $filePath = $argv[1];
    if (!file_exists($filePath)) {
        echo "❌ File tidak ditemukan: {$filePath}\n";
        exit(1);
    }
} else {
    // Coba cari file template yang terakhir didownload
    $files = glob(storage_path('app/*.xlsx'));
    if (count($files) > 0) {
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        $filePath = $files[0];
    }
}

if (!$filePath) {
    echo "❌ Tidak ada file Excel ditemukan\n";
    echo "Penggunaan: php debug_validate_excel.php /path/to/file.xlsx\n";
    exit(1);
}

echo "File: " . basename($filePath) . "\n";
echo "Ukuran: " . filesize($filePath) . " bytes\n";
echo "Modified: " . date('Y-m-d H:i:s', filemtime($filePath)) . "\n\n";

try {
    // Read all sheets
    $allSheets = Excel::toArray(new class {}, $filePath);
    
    echo "Total Sheets: " . count($allSheets) . "\n\n";
    
    foreach ($allSheets as $sheetIndex => $rows) {
        echo "=== SHEET " . ($sheetIndex + 1) . " ===\n";
        echo "Total rows: " . count($rows) . "\n\n";
        
        if (count($rows) === 0) {
            echo "⚠️ Sheet ini KOSONG\n\n";
            continue;
        }
        
        // Get first 10 rows
        for ($i = 0; $i < min(10, count($rows)); $i++) {
            $row = $rows[$i];
            echo "Baris " . ($i + 1) . ":\n";
            
            // Count empty cells
            $emptyCells = 0;
            $filledCells = 0;
            
            foreach ($row as $cellIndex => $cell) {
                if (trim((string)$cell) === '') {
                    $emptyCells++;
                } else {
                    $filledCells++;
                    if ($filledCells <= 5) {
                        echo "  Col[" . ($cellIndex) . "]: " . trim((string)$cell) . "\n";
                    }
                }
            }
            
            echo "  Filled cells: {$filledCells}, Empty cells: {$emptyCells}\n";
            
            // Check if this looks like header
            $headerKeywords = ['NIS', 'Nama', 'Lengkap', 'Jenis', 'Kelamin', 'Lahir', 'Agama', 'Ayah', 'Ibu'];
            $hasHeaderKeywords = 0;
            foreach ($row as $cell) {
                $cellStr = (string)$cell;
                foreach ($headerKeywords as $keyword) {
                    if (stripos($cellStr, $keyword) !== false) {
                        $hasHeaderKeywords++;
                    }
                }
            }
            
            if ($hasHeaderKeywords >= 3) {
                echo "  ⚠️ Ini mungkin HEADER ROW\n";
            }
            
            if ($filledCells === 0) {
                echo "  ❌ BARIS KOSONG - akan dilewatkan\n";
            }
            
            echo "\n";
        }
        
        // Count valid data rows (rows with at least NIS or Nama or NISN)
        echo "ANALISIS DATA:\n";
        $validRows = 0;
        $emptyRows = 0;
        
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $allEmpty = true;
            foreach ($row as $cell) {
                if (trim((string)$cell) !== '') {
                    $allEmpty = false;
                    break;
                }
            }
            
            if ($allEmpty) {
                $emptyRows++;
            } else {
                $validRows++;
            }
        }
        
        echo "- Total baris dengan data: {$validRows}\n";
        echo "- Total baris kosong: {$emptyRows}\n\n";
        
        if ($validRows === 1) {
            echo "⚠️ PERHATIAN: Hanya 1 baris dengan data (kemungkinan hanya HEADER)\n";
        } elseif ($validRows === 0) {
            echo "❌ MASALAH: Sheet ini TIDAK ADA data! (semua baris kosong)\n";
        } elseif ($validRows <= 3) {
            echo "⚠️ PERHATIAN: Hanya {$validRows} baris data (mungkin contoh saja)\n";
        }
        
        echo "\n";
    }
    
    // Simulate import
    echo "=== SIMULASI IMPORT ===\n";
    $import = new \App\Imports\SiswaImport();
    Excel::import($import, $filePath);
    
    $success = $import->getSuccessCount();
    $errors = $import->getErrors();
    
    echo "Import Results:\n";
    echo "- Success: {$success}\n";
    echo "- Errors: " . count($errors) . "\n";
    
    if ($success > 0) {
        echo "\n✓ BERHASIL: {$success} data akan diimport\n";
    } elseif (count($errors) > 0) {
        echo "\n❌ GAGAL dengan error:\n";
        foreach (array_slice($errors, 0, 10) as $error) {
            echo "  - {$error}\n";
        }
    } else {
        echo "\n❌ TIDAK ADA DATA YANG DIPROSES\n";
        echo "Kemungkinan penyebab:\n";
        echo "1. File tidak memiliki data (hanya header/contoh)\n";
        echo "2. Kolom nama_lengkap KOSONG di semua baris\n";
        echo "3. Header kolom tidak sesuai dengan template\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error membaca file: " . $e->getMessage() . "\n";
    echo "File mungkin: rusak, format salah, atau bukan Excel\n";
}
