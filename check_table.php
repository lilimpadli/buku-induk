<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'buku_induk7');
$result = $mysqli->query('DESCRIBE nilai_raports');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . PHP_EOL;
}
$mysqli->close();
