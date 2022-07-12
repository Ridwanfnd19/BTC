<?php
// Set header type konten.
// header("Content-Type: application/json; charset=UTF-8");

// // Deklarasi variable untuk koneksi ke database.
// $host     = "localhost";    // Server database
// $username = "root";         // Username database
// $password = "";             // Password database
// $database = "catatan"; // Nama database

include_once("../index.php");

// // Koneksi ke database.
// $conn = new mysqli($host, $username, $password, $database);

// // Deklarasi variable keyword buah.
$buah = $_GET["query"];

// Query ke database.
$query1  = $mysqli->query("SELECT * FROM btc WHERE level LIKE '%$buah%' ORDER BY id DESC");
$result = $query1->fetch_all(MYSQLI_ASSOC);

// Format bentuk data untuk autocomplete.
foreach($result as $data) {
    $coba[] = $data['level'];
}

$output['suggestions'] = array_values(array_unique($coba));

if (! empty($output)) {
    // Encode ke format JSON.
    echo json_encode($output);
}
?>