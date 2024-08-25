<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Input Tenatang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link href="../css/summernote-image-list.min.css">
    <script src="../js/summernote-image-list.min.js"></script>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <style>
        .image-list-content .col-lg-3 {width: 100%;}
        .image-list-content img {float:left; width: 20%}
        .image-list-content p {float:left; padding-left:20px}
        .image-list-item {padding:10px 0px 10px 0px}
    </style>
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
    $sql1   = "select * from tentang where id = '$id'";
    $q1     = mysqli_query($konek,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $judul  = $r1['judul'];
    $isi        = $r1['isi'];

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
            $sql1   = "update tentang  set judul = '$judul',isi='$isi',tgl_isi=now() where id = '$id'";
        }else{
            $sql1       = "insert into tentang (judul,isi) values ('$judul','$isi')";
        }
        $q1 = mysqli_query($konek, $sql1);
        if($q1){
            $sukses = "Sukses memasukkan data";
        }else{
            $error = "Gagal memasukkan data";
        }
    }

}?>

<div class="container mt-4">
    <a href="tentang.php" class="btn btn-primary">Kembali</a>
</div>

<div class="container">
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
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    $.upload(files[i]);
                }
            }
        },
        height: 200,
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontname", ["fontname"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["insert", ["link", "picture", "imageList", "video", "hr"]],
            ["help", ["help"]]
        ],
        dialogsInBody: true,
        imageList: {
            endpoint: "daftar_gambar.php",
            fullUrlPrefix: "../gambar/",
            thumbUrlPrefix: "../gambar/"
        }
    });
    $.upload = function(file) {
        let out = new FormData();
        out.append('file', file, file.name);

        $.ajax({
            method: 'POST',
            url: 'upload_gambar.php',
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function(img) {
                $('#summernote').summernote('insertImage', img);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>