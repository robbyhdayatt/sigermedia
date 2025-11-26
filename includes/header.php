<?php 
include 'config/koneksi.php'; 

// 1. QUERY MENGHITUNG TOTAL VIEWS (Real Data)
// Fungsi SUM() akan menjumlahkan nilai kolom 'views' dari semua baris data
$q_stat = mysqli_query($koneksi, "SELECT SUM(views) as total_dibaca FROM berita");
$d_stat = mysqli_fetch_assoc($q_stat);
$total_views = $d_stat['total_dibaca'];

// Jika null (belum ada berita), set jadi 0
if($total_views == null) { $total_views = 0; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siger Info Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body>

<div id="preloader">
    <div class="text-center">
        <div class="spinner mb-3 mx-auto"></div>
        <h6 class="fw-bold text-primary">SIGER INFO...</h6>
    </div>
</div>

<div class="bg-light py-2 border-bottom small text-muted">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-calendar-event me-2"></i>
            <?php 
            // Array untuk nama hari Indonesia
            $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            echo $hari[date('w')] . ", " . date('d F Y'); 
            ?>
        </div>
        
        <div class="d-flex align-items-center">
            <span class="me-3">
                <i class="bi bi-bar-chart-fill text-primary"></i> 
                Total Pembaca: <b><?= number_format($total_views) ?></b>
            </span>
            <span class="d-none d-md-inline">
                <a href="#" class="text-muted ms-2"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-muted ms-2"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-muted ms-2"><i class="bi bi-youtube"></i></a>
            </span>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-white bg-white sticky-top shadow-sm font-primary">
  <div class="container">
    
    <a class="navbar-brand p-0" href="<?= $base_url ?>">
        <img src="<?= $base_url ?>assets/images/logo.png" alt="Siger Info" height="50">
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav ms-auto text-uppercase fw-bold" style="font-size: 0.85rem;">
        
        <li class="nav-item">
            <a class="nav-link text-dark" href="<?= $base_url ?>">Home</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                Kanal Berita
            </a>
            <ul class="dropdown-menu shadow border-0 animate__animated animate__fadeIn">
                <?php 
                // Query hanya kategori UMUM
                $q_umum = mysqli_query($koneksi, "SELECT * FROM kategori WHERE jenis='umum' ORDER BY nama_kategori ASC");
                while($m = mysqli_fetch_array($q_umum)){
                ?>
                <li>
                    <a class="dropdown-item py-2" href="<?= $base_url ?>kategori.php?id=<?= $m['id'] ?>">
                        <?= $m['nama_kategori'] ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-geo-alt-fill"></i> Kabar Daerah
            </a>
            <ul class="dropdown-menu shadow border-0 animate__animated animate__fadeIn p-3" style="min-width: 400px;">
                <div class="row">
                    <?php 
                    // Query hanya kategori DAERAH
                    $q_daerah = mysqli_query($koneksi, "SELECT * FROM kategori WHERE jenis='daerah' ORDER BY nama_kategori ASC");
                    // Trik membagi 2 kolom
                    $no = 0;
                    echo '<div class="col-6">'; // Buka kolom kiri
                    while($d = mysqli_fetch_array($q_daerah)){
                        $no++;
                        // Jika sudah setengah data, pindah kolom kanan
                        if($no == 8) { echo '</div><div class="col-6 border-start">'; } 
                    ?>
                        <a class="dropdown-item py-1 small" href="<?= $base_url ?>kategori.php?id=<?= $d['id'] ?>">
                            <?= $d['nama_kategori'] ?>
                        </a>
                    <?php } ?>
                    </div> </div>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="<?= $base_url ?>tentang-kami.php">Tentang Kami</a>
        </li>

      </ul>

    </div>
  </div>
</nav>