<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        // Koneksi database
        $konek = mysqli_connect("localhost", "root", "", "dbtanaman");

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM artikel WHERE id = ?";
            $stmt = $konek->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $article = $result->fetch_assoc();
        }

        if ($article):
        ?>
            <h2>Edit Article</h2>
            <form action="update_artikel.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">
                <div class="mb-3">
                    <label for="judul_artikel" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="<?php echo htmlspecialchars($article['judul_artikel']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="isi_artikel" class="form-label">Isi Artikel</label>
                    <textarea class="form-control" id="isi_artikel" name="isi_artikel" rows="5" required><?php echo htmlspecialchars($article['isi_artikel']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="monitoring_table">Pilih Tabel Monitoring</label>
                    <select name="monitoring_table_id" id="monitoring_table" class="form-control" required>
                        <option value="">Pilih Tabel Monitoring</option>
                        <?php
                        // Query untuk mendapatkan tabel monitoring yang tersedia
                        $sqlMonitoring = "SELECT * FROM monitoring_tabel_data";
                        $resultMonitoring = mysqli_query($konek, $sqlMonitoring);

                        // Loop melalui hasil query dan tampilkan sebagai option
                        while ($row = mysqli_fetch_assoc($resultMonitoring)) {
                            $selected = ($row['id'] == $article['monitoring_tabel_id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['nama_tabel_monitoring']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gambar_artikel" class="form-label">Gambar (Biarkan Kosong jika ingin menyimpan gambar saat ini)</label>
                    <input type="file" class="form-control" id="gambar_artikel" name="gambar_artikel">
                    <?php
                    if (!empty($article['gambar_artikel'])):
                        echo '<img src="uploads/' . htmlspecialchars($article['gambar_artikel']) . '" alt="Image" style="max-width: 100px; margin-top: 10px;">';
                    endif;
                    ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        <?php
        else:
            echo '<p>Artikel tidak ditemukan.</p>';
        endif;
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
