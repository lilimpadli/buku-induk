<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$siswa = new App\Models\DataSiswa();
$ppdb = new App\Models\Ppdb();

echo "DataSiswa fillable:\n";
print_r($siswa->getFillable());

echo "\nPpdb fillable:\n";
print_r($ppdb->getFillable());
