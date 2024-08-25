<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Tambah Artikel Baru</h2>
        <form action="kirim_artikel.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul_artikel" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" required placeholder="Masukkan Judul Artikel Anda">
            </div>
            <div class="mb-3">
                <label for="isi_artikel" class="form-label">Isi Artikel</label>
                <textarea class="form-control" id="isi_artikel" name="isi_artikel" rows="5" required placeholder="Masukkan Isi Artikel Anda"></textarea>
            </div>
                <div class="mb-3">
                <label for="monitoring_table">Pilih Tabel Monitoring</label>
        <select name="monitoring_table_id" id="monitoring_table" class="form-control" required>
            <option value="">Pilih Tabel Monitoring</option>
            <?php
            // Koneksi ke database
            $konek = mysqli_connect("localhost", "root", "", "dbtanaman");

            // Query untuk mendapatkan tabel monitoring yang tersedia
            $sql = "SELECT * FROM monitoring_tabel_data";
            $result = mysqli_query($konek, $sql);

            // Loop melalui hasil query dan tampilkan sebagai option
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>{$row['nama_tabel_monitoring']}</option>";
            }

            mysqli_close($konek);
            ?>
        </select>
            </div>
            <div class="mb-3">
                <label for="gambar_artikel" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar_artikel" name="gambar_artikel"  required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
