<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbtanaman"; // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil artikel dari database
$sql = "SELECT id, judul_artikel FROM artikel ORDER BY id DESC";
$result = $conn->query($sql);

$artikel = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $artikel[] = $row;
    }
}

// Kirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode($artikel);

// Tutup koneksi
$conn->close();
?>
