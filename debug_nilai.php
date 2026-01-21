<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'buku_induk7');

echo "=== CEK SISWA 24 ===" . PHP_EOL;
$result = $mysqli->query("SELECT id, nama_lengkap FROM data_siswa WHERE id = 24");
if ($row = $result->fetch_assoc()) {
    echo "Siswa: " . $row['nama_lengkap'] . PHP_EOL;
    
    // Cek nilai raport
    $values = $mysqli->query("SELECT * FROM nilai_raports WHERE siswa_id = 24 LIMIT 5");
    echo "Nilai Raport Count: " . $values->num_rows . PHP_EOL;
    while ($v = $values->fetch_assoc()) {
        echo "- Mapel ID: " . $v['mata_pelajaran_id'] . ", Nilai: " . $v['nilai_akhir'] . ", Tahun: " . $v['tahun_ajaran'] . ", Sem: " . $v['semester'] . PHP_EOL;
    }
} else {
    echo "Siswa tidak ditemukan" . PHP_EOL;
}

echo PHP_EOL . "=== SISWA DENGAN NILAI ===" . PHP_EOL;
$result = $mysqli->query("
    SELECT DISTINCT ds.id, ds.nama_lengkap, COUNT(nr.id) as total_nilai
    FROM data_siswa ds
    LEFT JOIN nilai_raports nr ON ds.id = nr.siswa_id
    WHERE nr.id IS NOT NULL
    GROUP BY ds.id
    LIMIT 5
");
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - " . $row['nama_lengkap'] . " (" . $row['total_nilai'] . " nilai)" . PHP_EOL;
}

$mysqli->close();
