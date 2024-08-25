<?php
// Koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil nama file gambar
    $sql = "SELECT gambar_artikel FROM artikel WHERE id = ?";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
    
    if ($article) {
        $imagePath = 'uploads/' . $article['gambar_artikel'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Hapus artikel dari database
        $sql = "DELETE FROM artikel WHERE id = ?";
        $stmt = $konek->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Redirect ke index.php dengan parameter status
    header('Location: index.php?status=deleted');
    exit();
}
?>
