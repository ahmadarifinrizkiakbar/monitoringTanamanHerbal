<?php
// Koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $judul_artikel = $_POST['judul_artikel'];
    $isi_artikel = $_POST['isi_artikel'];
    $monitoring_table_id = intval($_POST['monitoring_table_id']);
    $newImage = '';
    $oldImage = '';

    // Ambil data artikel lama
    $sql = "SELECT gambar_artikel FROM artikel WHERE id = ?";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldArticle = $result->fetch_assoc();

    if ($oldArticle) {
        $oldImage = $oldArticle['gambar_artikel'];
    }

    if (isset($_FILES['gambar_artikel']) && $_FILES['gambar_artikel']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['gambar_artikel']['tmp_name'];
        $fileName = $_FILES['gambar_artikel']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedExts = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $newImage = $fileName;

                // Hapus gambar lama jika ada
                if (!empty($oldImage)) {
                    $oldImagePath = $uploadFileDir . $oldImage;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $newImage = $oldImage;
    }

    // Update artikel dengan pilihan tabel monitoring
    $sql = "UPDATE artikel SET judul_artikel = ?, isi_artikel = ?, gambar_artikel = ?, monitoring_tabel_id = ? WHERE id = ?";
    $stmt = $konek->prepare($sql);
    $stmt->bind_param("sssii", $judul_artikel, $isi_artikel, $newImage, $monitoring_table_id, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Artikel berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Tidak ada perubahan yang dilakukan atau pembaruan gagal.'); window.location.href='index.php';</script>";
    }

    exit();
}
?>
