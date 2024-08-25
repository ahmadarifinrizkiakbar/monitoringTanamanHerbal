<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
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
$sukses = "";
$katakunci = (isset($_GET['katakunci']))?$_GET['katakunci']:"";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "delete from halaman where id = '$id'";
    $q1     = mysqli_query($konek, $sql1);
    if ($q1) {
        echo "<script>alert('Tentang berhasil disimpan!'); window.location.href='tentang.php';</script>";
    }
}

?>

<div class="container">
<h1>Halaman Admin Home</h1>
<p>
    <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Buat Halaman Baru" />
    </a>
</p>
<?php
if ($sukses) {
?>
<div class="alert alert-primary" role="alert">
    <?php echo $sukses ?>
</div>
<?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan kata kunci" name="katakunci"
            value="<?php echo $katakunci?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Tulisan" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-stripped">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th> judul </th>
            <th> Isi </th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
         $sqltambahan = "";
         $per_halaman = 2;
         if ($katakunci != '') {
             $array_katakunci = explode(" ", $katakunci);
             for ($x = 0; $x < count($array_katakunci); $x++) {
                 $sqlcari[] = "(judul like '%" . $array_katakunci[$x] . "%' or kutipan like '%" . $array_katakunci[$x] . "%' or isi like '%" . $array_katakunci[$x] . "%')";
             }
             $sqltambahan    = " where " . implode(" or ", $sqlcari);
         }
        $sql1 = "select * from halaman $sqltambahan";
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($konek,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        $sql1   = $sql1." order by id desc limit $mulai,$per_halaman";
        $q1 = mysqli_query($konek, $sql1);
        while($r1 = mysqli_fetch_array($q1)){
            ?>
        <tr>
            <td><?php echo $nomor++ ?></td>
            <td><?php echo $r1['judul'] ?></td>
            <td> <?php echo $r1['isi'] ?></td>
            <td>
                <a href="halaman_input.php?id=<?php echo $r1['id']?>">
                    <span class="badge bg-warning text-dark">Edit</span>
                </a>

                <a href="halaman.php?op=delete&id=<?php echo $r1['id'] ?>"
                    onclick="return confirm('Apakah anda yakin mau hapus data ?')">
                    <span class="badge bg-danger">Delete</span>
                </a>
            </td>
        </tr>
        <?php

        }

    ?>
    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php 
        $cari = isset($_GET['cari'])? $_GET['cari'] : "";

        for($i=1; $i <= $pages; $i++){
            ?>
        <li class="page-item">
            <a class="page-link"
                href="halaman.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
        <?php
        }
        ?>
    </ul>
</nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
