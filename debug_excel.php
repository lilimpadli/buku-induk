<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = 'C:\Users\ADVAN\Downloads\template_data_pegawai.xlsx';

if (!file_exists($filePath)) {
    die("File tidak ditemukan: $filePath\n");
}

$spreadsheet = IOFactory::load($filePath);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

echo "=== HEADER (Baris 1) ===\n";
if (isset($rows[0])) {
    foreach ($rows[0] as $i => $val) {
        echo "Index $i: '$val'\n";
    }
}

echo "\n=== BARIS 2 (Data Pertama - ADE ASIKIN) ===\n";
if (isset($rows[1])) {
    foreach ($rows[1] as $i => $val) {
        echo "Index $i: '$val'\n";
    }
}

echo "\n=== BARIS 5 (ANI KARLINA) ===\n";
if (isset($rows[4])) {
    foreach ($rows[4] as $i => $val) {
        echo "Index $i: '$val'\n";
    }
}

echo "\n=== TOTAL BARIS: " . count($rows) . " ===\n";