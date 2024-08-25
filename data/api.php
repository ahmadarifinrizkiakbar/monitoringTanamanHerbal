<?php
// api.php

// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (!$konek) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data terbaru dari tabel yang dipilih
$table = $_GET['table']; // Get the table name from the request
$sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";
$result = mysqli_query($konek, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($konek));
}

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $response = array(
        'suhuTanah' => $data['suhuTanah'],
        'kelembabanTanah' => $data['kelembabanTanah'],
        'phTanah' => $data['phTanah'],
        'suhuUdara' => $data['suhuUdara'],
        'kelembabanUdara' => $data['kelembabanUdara']
    );
} else {
    $response = array(
        'suhuTanah' => 0,
        'kelembabanTanah' => 0,
        'phTanah' => 0,
        'suhuUdara' => 0,
        'kelembabanUdara' => 0
    );
}

echo json_encode($response);

// Tutup koneksi
mysqli_close($konek);
?>