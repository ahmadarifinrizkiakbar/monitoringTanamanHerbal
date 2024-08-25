<?php 
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");?>

<?php
function url_dasar(){
    //$_SERVER['SERVER_NAME'] : alamat website, misalkan websitemu.com
    // $_SERVER['SCRIPT_NAME'] : directory website, websitemu.com/blog/ $_SERVER['SCRIPT_NAME'] : blog
    $url_dasar  = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
    return $url_dasar;
}
function ambil_gambar($id_tulisan){
    global $konek;
    $sql1 = "select * from tentang where id = '$id_tulisan'";
    $q1   = mysqli_query($konek,$sql1);
    $r1   = mysqli_fetch_array($q1);
    $text = $r1['isi'];

    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $text, $img);
    $gambar = $img[1]; // ../gambar/filename.jpg
    $gambar = str_replace("../gambar/",url_dasar()."/gambar/",$gambar);
    return $gambar;
}

function ambil_judul($id_tulisan){
    global $konek;
    $sql1   = "select * from tentang where id = '$id_tulisan'";
    $q1     = mysqli_query($konek,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $text   = $r1['judul'];
    return $text;
}

function ambil_isi($id_tulisan){
    global $konek;
    $sql1   = "select * from tentang where id = '$id_tulisan'";
    $q1     = mysqli_query($konek,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $text   = strip_tags($r1['isi']);
    return $text;
}

function bersihkan_judul($judul){
    $judul_baru     = strtolower($judul);
    $judul_baru     = preg_replace("/[^a-zA-Z0-9\s]/","",$judul_baru);
    $judul_baru     = str_replace(" ","-",$judul_baru);
    return $judul_baru;
}

function dapatkan_id(){
    $id     ="";
    if(isset($_SERVER['PATH_INFO'])){
        $id = dirname($_SERVER['PATH_INFO']);
        $id = preg_replace("/[^0-9]/","",$id);
    }
    return $id;
}

function set_isi($isi){
    $isi    = str_replace("../gambar/",url_dasar()."/gambar/",$isi);
    return $isi;
}

function maximum_kata($isi,$maximum){
    $array_isi = explode(" ",$isi);
    $array_isi = array_slice($array_isi,0,$maximum);
    $isi = implode(" ",$array_isi);
    return $isi;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Lingkungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">


    <style>
    .profile-img {
        width: 150px;
        /* Atur ukuran gambar sesuai kebutuhan */
        height: 150px;
        /* Menjaga gambar tetap proporsional */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Tambahkan bayangan untuk estetika */
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .content-section {
        padding: 40px 0;
    }

    .content-section h2,
    .content-section h3 {
        color: #2c3e50;
    }

    .content-section p {
        color: #34495e;
    }

    .mission,
    .vision {
        background-color: #f0f4f7;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .btn-custom {
        background-color: #5dade2;
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #3498db;
    }

    body {
        font-family: 'Comic Sans MS', cursive, sans-serif;
        background-color: #f0f8ff;
        color: #333;
        margin: 0;
        padding: 0;

    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .title {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #ff4500;
        text-align: center;
    }

    .content-wrapper {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
        width: 100%;
    }

    .content {
        flex: 1;
        margin-right: 20px;
        text-align: left;
    }

    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .content p {
        font-size: 1.125rem;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .content {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .content img {
            width: 80%;
        }

    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logo/logo.png" alt="Logo"> </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Artikel
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                        // Koneksi database
                        $konek = mysqli_connect("localhost", "root", "", "dbtanaman");

                        // Ambil semua artikel
                        $result = mysqli_query($konek, "SELECT * FROM artikel");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li><a class="dropdown-item" href="artikel.php?id=' . $row['id'] . '">' . htmlspecialchars($row['judul_artikel']) . '</a></li>';
                        }
                        ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Tentang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container content-section text-center">
        <img src="<?php echo ambil_gambar('1') ?>" class="profile-img img-fluid" alt="Tanaman Herbal">
        <!-- Ganti dengan URL gambar yang sesuai -->
        <h2><?php echo ambil_judul('1') ?></h2>
        <p><?php echo ambil_isi('1') ?></p>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="mission">
                    <h3><?php echo ambil_judul('2') ?></h3>
                    <p>><?php echo ambil_isi('2') ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vision">
                    <h3><?php echo ambil_judul('3') ?></h3>
                    <p>><?php echo ambil_isi('3') ?></p>
                </div>
            </div>
        </div>
      


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="js/script.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_articles.php')
                .then(response => response.json())
                .then(data => {
                    const dropdownMenu = document.getElementById('dropdownArticles');
                    dropdownMenu.innerHTML = ''; // Kosongkan dropdown terlebih dahulu
                    data.forEach(article => {
                        const articleHTML = `
                            <li><a class="dropdown-item" href="artikel.php?id=${article.id}">${article.title}</a></li>
                        `;
                        dropdownMenu.innerHTML += articleHTML;
                    });
                });
        });
        </script>

        <div class="footer" style="text-align: center">
            Tanaman Herbal.
            <strong>2024</strong>
        </div>

        <!-- Bootstrap JavaScript and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>




</body>

</html>