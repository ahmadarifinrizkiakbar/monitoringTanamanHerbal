<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            <a class="navbar-brand" href="halaman.php">Admin Home</a>
            <a class="navbar-brand" href="tentang.php">Admin Tentang</a>
        </div>
            
    </nav>
    <div class="container mt-4">
        <h2>Kelola Artikel</h2>
        <a href="tambah_artikel.php" class="btn btn-primary">Tambah Artikel Baru</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi database
                $konek = mysqli_connect("localhost", "root", "", "dbtanaman");

                // Ambil semua artikel
                $result = mysqli_query($konek, "SELECT * FROM artikel");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['judul_artikel']) . '</td>';
                    echo '<td>' . htmlspecialchars(substr($row['isi_artikel'], 0, 50)) . '...</td>';
                    echo '<td>';
                    if (!empty($row['gambar_artikel'])) {
                        echo '<img src="uploads/' . htmlspecialchars($row['gambar_artikel']) . '" alt="Image" style="max-width: 100px;">';
                    }
                    echo '</td>';
                    echo '<td>';
                    echo '<a href="edit_artikel.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                    echo '<a href="hapus_artikel.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus artikel ini?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
     <!-- JavaScript untuk menampilkan alert setelah penghapusan -->
     <script>
        window.onload = function() {
            // Cek apakah parameter 'status' ada dalam URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'deleted') {
                alert('Artikel berhasil dihapus!');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
