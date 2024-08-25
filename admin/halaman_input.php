<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Input Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            <a class="navbar-brand" href="halaman.php">Admin Home</a>
            <a class="navbar-brand" href="tentang.php">Admin Tentang</a>
    </nav>
<?php
// Koneksi database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");
$judul = "";
$isi = "";
$error = "";
$sukses = "";
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1   = "select * from halaman where id = '$id'";
    $q1     = mysqli_query($konek,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $judul  = $r1['judul'];
    $isi    = $r1['isi'];

    if($isi == ''){
        $error  = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    if($judul == "" or $isi == ""){
        $error = "Silahkan masukkan semua data judul dan isi";
    }

    if(empty($error)){
        if($id != ""){
            $sql1   = "update halaman set judul = '$judul',isi='$isi',tgl_isi=now() where id = '$id'";
        }else{
            $sql1       = "insert into halaman(judul,isi) values ('$judul','$isi')";
        }
        $q1 = mysqli_query($konek, $sql1);
        if($q1){
            $sukses = "Sukses memasukkan data";
        }else{
            $error = "Gagal memasukkan data";
        }
    }

}


?>

<div class="container">
<h1> Input Data Home</h1>

<div class="container mt-4">
    <a href="halaman.php" class="btn btn-primary">Kembali</a>
</div>

<?php 
    if($error){
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php   
    }
?>
<?php 
    if($sukses){
?>
    <div class="alert alert-primary" role="alert">
        <?php  echo "<script>alert('Tentang berhasil disimpan!'); window.location.href='tentang.php';</script>"; ?>
    </div>
<?php   
    }
?>

<form action="" method="POST">
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <input type="text" class="form-control" id="judul" value="<?php echo $judul ?>" name="judul">
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
        <textarea name="isi" class="form-control" id="summernote"><?php echo $isi ?></textarea>
    </div>
    <button type="submit" name="simpan" value="Simpan Data"class="btn btn-primary">Simpan Data</button>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>