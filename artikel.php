<!--  memangil tabel pada database sesuai inputan admin -->
<?php
// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "dbtanaman");

if (!$konek) {
    die("Connection failed: " . mysqli_connect_error());
}

// Dapatkan artikel berdasarkan ID
$artikel_id = $_GET['id'];

// Query untuk mendapatkan artikel dan tabel monitoring yang dipilih
$sql = "SELECT artikel.*, monitoring_tabel_data.nama_tabel_monitoring 
        FROM artikel 
        JOIN monitoring_tabel_data ON artikel.monitoring_tabel_id = monitoring_tabel_data.id 
        WHERE artikel.id = ?";
$stmt = $konek->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $konek->error);
}

$stmt->bind_param("i", $artikel_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

// Periksa apakah artikel ditemukan dan tabel monitoring dipilih
if (!$article || !isset($article['nama_tabel_monitoring'])) {
    die("Artikel tidak ditemukan atau tabel monitoring tidak dipilih.");
}

// Ambil nama tabel monitoring dari hasil query
$table = $article['nama_tabel_monitoring'];

// Tutup koneksi
mysqli_close($konek);
?>
<!-- penutup memangil tabel pada database sesuai inputan admin -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['judul_artikel']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style-media.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
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
    .judul_artikel {
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
    .isi_artikel {
        flex: 1;
        margin-right: 20px;
        text-align: justify;
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
            text-align:justify;
        }
        .content img {
            width: 10%;
        }
    }  
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="logo/logo.png" alt="Logo"> </a></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Artikel
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="dropdownArticles">
                            <!-- Artikel akan dimuat di sini dengan JavaScript -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tantang.html">Tentang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- menampilkan data artikel -->
    <div class="container mt-4" data-aos="fade-up">
        <h2 class="judul_artikel"><?php echo htmlspecialchars($article['judul_artikel']); ?></h2>
        <div class="content-wrapper">
            <div class="isi_artikel">
                <p><?php echo htmlspecialchars($article['isi_artikel']); ?></p>
            </div>
            <?php if ($article['gambar_artikel']): ?>
                <img class="article-image" src="admin/uploads/<?php echo htmlspecialchars($article['gambar_artikel']); ?>" alt="<?php echo htmlspecialchars($article['judul_artikel']); ?>">
            <?php endif; ?>
        </div>
    </div>

    <!-- Untuk menampilkan nilai data terbaru  -->
    <div class="container mt-2">
        <div class="row justify-content-center">
            <!-- Data Terbaru -->
            <div class="col-md-10 mb-2">
                <div class="card mx-auto">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Data Terbaru</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-2 mb-2">
                                <div class="data-box">
                                    <p>Suhu Tanah:</p>
                                    <div class="data-value">
                                    <h4 id="suhuTanah">0</h4>
                                    <p class="unit"> °C</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="data-box">
                                    <p>Kelembaban Tanah:</p>
                                    <div class="data-value">
                                    <h4 id="kelembabanTanah">0</h4>
                                    <p class="unit"> %</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="data-box">
                                    <p>pH Tanah:</p>
                                    <h4 id="phTanah">0</h4>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="data-box">
                                    <p>Suhu Udara:</p>
                                    <div class="data-value">
                                    <h4 id="suhuUdara">0</h4>
                                    <p class="unit">°C</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <div class="data-box">
                                    <p>Kelembaban Udara:</p>
                                    <div class="data-value">
                                    <h4 id="kelembabanUdara">0</h4>
                                    <p class="unit">%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Akhiran Untuk menampilkan nilai data terbaru  -->

    <!-- Script update data terbaru secara realtime -->
    <script type="text/javascript">
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    type: "GET",
                    url: "data/api.php",
                    data: { table: "<?php echo $table; ?>" },
                    dataType: "json",
                    success: function(data) {
                        $("#suhuTanah").html(data.suhuTanah);
                        $("#kelembabanTanah").html(data.kelembabanTanah);
                        $("#phTanah").html(data.phTanah);
                        $("#suhuUdara").html(data.suhuUdara);
                        $("#kelembabanUdara").html(data.kelembabanUdara);
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    }
                });
            }
            // inisiasi fetchData 
            fetchData();

            // Mengupdate data dalam waktu 5 detik
            setInterval(fetchData, 5000);
        });
    </script>
    <!-- Akhiran Untuk menampilkan nilai data terbaru  -->

                
            <!-- Menampilkan Grafik -->
            <!-- Grafik 1: Bar Chart Kelembaban Tanah -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Kelembaban Tanah (%)</h5>
                    </div>
                    <div class="card-body p-1">
                        <canvas id="kelembabanTanahBarChart" width="250" height="125"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik 3: Donut Chart pH Tanah -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>pH Tanah</h5>
                    </div>
                    <div class="card-body p-1">
                        <canvas id="phTanahLineChart" width="250" height="125"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik 2: Line Chart Suhu Tanah -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Suhu Tanah (°C)</h5>
                    </div>
                    <div class="card-body p-1">
                        <canvas id="suhuTanahLineChart" width="250" height="125"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik 4: Area Chart Suhu Udara -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Suhu Udara (°C)</h5>
                    </div>
                    <div class="card-body p-1">
                        <canvas id="suhuUdaraAreaChart" width="250" height="125"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik 5: Bar Chart Kelembaban Udara -->
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Kelembaban Udara (%)</h5>
                    </div>
                    <div class="card-body p-1">
                        <canvas id="kelembabanUdaraBarChart" width="250" height="125"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <!-- untuk menampilkan dropdown pada navbar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('data/ambil_artikel.php')
                .then(response => response.json())
                .then(data => {
                    const dropdownMenu = document.getElementById('dropdownArticles');
                    dropdownMenu.innerHTML = ''; // Kosongkan dropdown terlebih dahulu
                    data.forEach(article => {
                        const articleHTML = `
                            <li><a class="dropdown-item" href="artikel.php?id=${article.id}">${article.judul_artikel}</a></li>
                        `;
                        dropdownMenu.innerHTML += articleHTML;
                    });
                });
        });
    </script>

<!-- Script untuk update dan tampilkan grafik secara realtime -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const updateInterval = 5000; // Interval waktu dalam milidetik (2 detik)
    const maxDataPoints = 20; // Jumlah maksimum titik data yang ditampilkan di grafik

    // Data awal
    let dataLabels = [];
    let suhuTanahData = [];
    let kelembabanTanahData = [];
    let phTanahData = [];
    let suhuUdaraData = [];
    let kelembabanUdaraData = [];

    // Grafik Kelembaban Tanah Bar Chart
    const ctx1 = document.getElementById('kelembabanTanahBarChart').getContext('2d');
    const kelembabanTanahBarChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Kelembaban Tanah (%)',
                data: kelembabanTanahData,
                fill: true,
                backgroundColor: 'rgba(255, 192, 203, 0.2)',
                borderColor: 'rgba(238, 130, 238, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Waktu'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Kelembaban Tanah (%)'
                    }
                }
            }
        }
    });

    // Grafik Suhu Tanah Area Chart
    const ctx2 = document.getElementById('suhuTanahLineChart').getContext('2d');
    const suhuTanahAreaChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Suhu Tanah (°C)',
                data: suhuTanahData,
                fill: true, // Isi area di bawah kurva
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Waktu'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Suhu Tanah (°C)'
                    }
                }
            }
        }
    });

    // Grafik pH Tanah Line Chart
    const ctx3 = document.getElementById('phTanahLineChart').getContext('2d');
    const phTanahLineChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'pH Tanah',
                data: phTanahData,
                fill: false,
                borderColor: 'rgba(153, 102, 255, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Waktu'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'pH Tanah'
                    }
                }
            }
        }
    });

    // Grafik Suhu Udara Area Chart
    const ctx4 = document.getElementById('suhuUdaraAreaChart').getContext('2d');
    const suhuUdaraAreaChart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Suhu Udara (°C)',
                data: suhuUdaraData,
                fill: true,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Waktu'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Suhu Udara (°C)'
                    }
                }
            }
        }
    });

    // Grafik Kelembaban Udara Bar Chart
    const ctx5 = document.getElementById('kelembabanUdaraBarChart').getContext('2d');
    const kelembabanUdaraBarChart = new Chart(ctx5, {
        type: 'line',
        data: {
            labels: dataLabels,
            datasets: [{
                label: 'Kelembaban Udara (%)',
                data: kelembabanUdaraData,
                backgroundColor: 'rgba(255, 215, 0, 0.2)',
                borderColor: 'rgba(215, 185, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Waktu'
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Kelembaban Udara (%)'
                    }
                }
            }
        }
    });

    function updateCharts() {
    fetch('data/data.php?id=<?php echo $artikel_id; ?>')
        .then(response => response.json())
        .then(data => {
            const currentTime = new Date().toLocaleTimeString();

            // Tambahkan data terbaru ke array
            dataLabels.push(currentTime);
            suhuTanahData.push(data[data.length - 1].suhuTanah);
            kelembabanTanahData.push(data[data.length - 1].kelembabanTanah);
            phTanahData.push(data[data.length - 1].phTanah);
            suhuUdaraData.push(data[data.length - 1].suhuUdara);
            kelembabanUdaraData.push(data[data.length - 1].kelembabanUdara);

            // Batasi jumlah data di grafik (misalnya 20 titik)
            if (dataLabels.length > maxDataPoints) {
                dataLabels.shift();
                suhuTanahData.shift();
                kelembabanTanahData.shift();
                phTanahData.shift();
                suhuUdaraData.shift();
                kelembabanUdaraData.shift();
            }

            // Update grafik dengan data baru
            kelembabanTanahBarChart.data.labels = dataLabels;
            kelembabanTanahBarChart.data.datasets[0].data = kelembabanTanahData;
            kelembabanTanahBarChart.update();

            suhuTanahAreaChart.data.labels = dataLabels;
            suhuTanahAreaChart.data.datasets[0].data = suhuTanahData;
            suhuTanahAreaChart.update();

            phTanahLineChart.data.labels = dataLabels;
            phTanahLineChart.data.datasets[0].data = phTanahData;
            phTanahLineChart.update();

            suhuUdaraAreaChart.data.labels = dataLabels;
            suhuUdaraAreaChart.data.datasets[0].data = suhuUdaraData;
            suhuUdaraAreaChart.update();

            kelembabanUdaraBarChart.data.labels = dataLabels;
            kelembabanUdaraBarChart.data.datasets[0].data = kelembabanUdaraData;
            kelembabanUdaraBarChart.update();
        })
        .catch(error => console.error('Error fetching data:', error));
}


    // Update grafik secara berkala
    setInterval(updateCharts, updateInterval);
});


</script>

<script>AOS.init();</script>

<div class="footer" style="text-align: center">
    Tanaman Herbal.
    <strong>2024</strong>
</div>
</body>
</html>
