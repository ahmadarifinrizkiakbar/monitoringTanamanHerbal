<?php
// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil data dari form
$judul_artikel = $_POST['judul_artikel'];
$isi_artikel = $_POST['isi_artikel'];
$monitoring_table_id = $_POST['monitoring_table_id'];
$gambar_artikel = $_FILES['gambar_artikel']['name'];
$imageTmpName = $_FILES['gambar_artikel']['tmp_name'];
$imageDestination = 'uploads/' . $gambar_artikel;

move_uploaded_file($imageTmpName, $imageDestination);

// Query untuk menyimpan artikel ke database
$sql = "INSERT INTO artikel (judul_artikel, isi_artikel, gambar_artikel, monitoring_tabel_id) VALUES (?, ?, ?, ?)";

$stmt = $konek->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $konek->error);
}

// Bind parameter
$stmt->bind_param("sssi", $judul_artikel, $isi_artikel, $gambar_artikel, $monitoring_table_id);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Artikel berhasil disimpan!'); window.location.href='index.php';</script>";
} else {
    echo "Gagal menyimpan artikel.";
}

// Tutup statement dan koneksi
$stmt->close();
mysqli_close($konek);
?>
