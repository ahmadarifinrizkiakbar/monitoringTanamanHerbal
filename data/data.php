<?php
// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Dapatkan artikel berdasarkan ID
$artikel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Periksa apakah ID artikel valid
if ($artikel_id <= 0) {
    die("ID artikel tidak valid.");
}

// Query untuk mendapatkan artikel dan tabel monitoring yang dipilih
$sql = "SELECT artikel.*, monitoring_tabel_data.nama_tabel_monitoring 
        FROM artikel 
        JOIN monitoring_tabel_data ON artikel.monitoring_tabel_id = monitoring_tabel_data.id 
        WHERE artikel.id = ?";
        
$stmt = $konek->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $konek->error);
}

$stmt->bind_param("i", $artikel_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

// Periksa apakah artikel ditemukan dan tabel monitoring dipilih
if (!$article || !isset($article['nama_tabel_monitoring'])) {
    die("Artikel tidak ditemukan atau tabel monitoring tidak dipilih.");
}

// Ambil nama tabel monitoring dari hasil query
$table = $article['nama_tabel_monitoring'];

// Ambil data terbaru dari tabel yang dipilih
$sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 20"; // Ambil 20 data terbaru
$result = mysqli_query($konek, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Kirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);

// Tutup koneksi
mysqli_close($konek);
?>
