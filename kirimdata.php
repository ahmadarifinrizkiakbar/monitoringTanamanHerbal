<?php

$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil artikel_id terbaru dari tabel artikel
$result = mysqli_query($konek, "SELECT id FROM artikel ORDER BY id DESC LIMIT 1");

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $artikel_id = $row['id']; // artikel_id terbaru
} else {
    die("Gagal mendapatkan artikel_id: " . mysqli_error($konek));
}

// Baca data yang dikirim dari ESP32
$suhuTanah = $_GET['suhuTanah'];
$kelembabanTanah = $_GET['kelembabanTanah'];
$phTanah = $_GET['phTanah'];
$suhuUdara = $_GET['suhuUdara'];
$kelembabanUdara = $_GET['kelembabanUdara'];
$suhuTanah2 = $_GET['suhuTanah2'];
$kelembabanTanah2 = $_GET['kelembabanTanah2'];
$phTanah2 = $_GET['phTanah2'];

// Simpan data ke tabel Monitoring_Tabel_1
$simpan_monitoring_1 = mysqli_query($konek, "INSERT INTO monitoring_tabel_1 (artikel_id, suhuTanah, kelembabanTanah, phTanah, suhuUdara, kelembabanUdara) VALUES ('$artikel_id', '$suhuTanah', '$kelembabanTanah', '$phTanah', '$suhuUdara', '$kelembabanUdara')");

// Simpan data ke tabel Monitoring_Tabel_2
$simpan_monitoring_2 = mysqli_query($konek, "INSERT INTO monitoring_tabel_2 (artikel_id, suhuTanah, kelembabanTanah, phTanah, suhuUdara, kelembabanUdara) VALUES ('$artikel_id', '$suhuTanah2', '$kelembabanTanah2', '$phTanah2', '$suhuUdara', '$kelembabanUdara')");

if ($simpan_monitoring_2) {
    echo "Data berhasil dikirim ke monitoring_tabel_1 dan 2";
} else {
    echo "Gagal dikirim ke monitoring_tabel_2: " . mysqli_error($konek);
}

// Tutup koneksi
mysqli_close($konek);

?>
