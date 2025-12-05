<?php 
// Pastikan koneksi sudah ada
if(!isset($koneksi)){ include 'config/koneksi.php'; }

// 1. AMBIL DATA IDENTITAS WEBSITE (Dari Pengaturan Admin)
$q_info = mysqli_query($koneksi, "SELECT * FROM identitas WHERE id=1");
$d_info = mysqli_fetch_assoc($q_info);

// Fallback jika data kosong (Jaga-jaga)
if(!$d_info){
    $d_info = [
        'nama_website' => 'Siger Info',
        'deskripsi' => 'Portal Berita Terpercaya',
        'logo' => 'logo.png',
        'facebook' => '#',
        'instagram' => '#'
    ];
}

// 2. LOGIKA SEO OTOMATIS
// Default Values (Mengambil dari Database Identitas)
$page_title = $d_info['nama_website'] . " - " . substr($d_info['deskripsi'], 0, 50);
$page_desc  = $d_info['deskripsi'];
$page_img   = $base_url . "assets/images/" . $d_info['logo']; 
$page_url   = $base_url;

// Cek apakah sedang membuka detail berita?
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_seo = (int)$_GET['id'];
    
    $stmt_seo = mysqli_prepare($koneksi, "SELECT judul, isi_berita, gambar, slug_berita FROM berita WHERE id=?");
    mysqli_stmt_bind_param($stmt_seo, "i", $id_seo);
    mysqli_stmt_execute($stmt_seo);
    $res_seo = mysqli_stmt_get_result($stmt_seo);
    
    if(mysqli_num_rows($res_seo) > 0){
        $d_seo = mysqli_fetch_assoc($res_seo);
        
        // Judul Berita + Nama Website
        $page_title = $d_seo['judul'] . " - " . $d_info['nama_website'];
        $page_desc  = substr(strip_tags($d_seo['isi_berita']), 0, 150) . "...";
        $page_img   = $base_url . "uploads/" . $d_seo['gambar'];
        $page_url   = $base_url . "detail/" . $id_seo . "/" . $d_seo['slug_berita'];
    }
}

// 3. QUERY TOTAL VIEWS
$q_stat = mysqli_query($koneksi, "SELECT SUM(views) as total_dibaca FROM berita");
$d_stat = mysqli_fetch_assoc($q_stat);
$total_views = $d_stat['total_dibaca'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $page_desc ?>">
    
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= $page_url ?>">
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $page_desc ?>">
    <meta property="og:image" content="<?= $page_img ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= $page_url ?>">
    <meta property="twitter:title" content="<?= $page_title ?>">
    <meta property="twitter:description" content="<?= $page_desc ?>">
    <meta property="twitter:image" content="<?= $page_img ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body>

<div id="preloader">
    <div class="text-center">
        <div class="spinner mb-3 mx-auto"></div>
        <h6 class="fw-bold text-primary"><?= strtoupper($d_info['nama_website']) ?>...</h6>
    </div>
</div>

<div class="bg-light py-2 border-bottom small text-muted">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-calendar-event me-2"></i>
            <?php 
            $hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            echo $hari[date('w')] . ", " . date('d F Y'); 
            ?>
        </div>
        
        <div class="d-flex align-items-center">
            <!-- <span class="me-3">
                <i class="bi bi-bar-chart-fill text-primary"></i> 
                Pembaca: <b><?= number_format($total_views) ?></b>
            </span> -->
            <span class="d-none d-md-inline">
                <?php if(!empty($d_info['facebook'])){ ?>
                    <a href="<?= $d_info['facebook'] ?>" target="_blank" class="text-muted ms-2"><i class="bi bi-facebook"></i></a>
                <?php } ?>
                
                <?php if(!empty($d_info['instagram'])){ ?>
                    <a href="<?= $d_info['instagram'] ?>" target="_blank" class="text-muted ms-2"><i class="bi bi-instagram"></i></a>
                <?php } ?>
            </span>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-white bg-white sticky-top shadow-sm font-primary">
  <div class="container">
    
    <a class="navbar-brand p-0" href="<?= $base_url ?>">
        <img src="<?= $base_url ?>assets/images/<?= $d_info['logo'] ?>" alt="<?= $d_info['nama_website'] ?>" height="50">
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
                $q_umum = mysqli_query($koneksi, "SELECT * FROM kategori WHERE jenis='umum' ORDER BY nama_kategori ASC");
                while($m = mysqli_fetch_array($q_umum)){
                ?>
                <li>
                    <a class="dropdown-item py-2" href="<?= $base_url ?>kategori/<?= $m['id'] ?>/<?= $m['slug_kategori'] ?>">
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
                    $q_daerah = mysqli_query($koneksi, "SELECT * FROM kategori WHERE jenis='daerah' ORDER BY nama_kategori ASC");
                    $no = 0;
                    echo '<div class="col-6">'; 
                    while($d = mysqli_fetch_array($q_daerah)){
                        $no++;
                        if($no == 8) { echo '</div><div class="col-6 border-start">'; } 
                    ?>
                        <a class="dropdown-item py-1 small" href="<?= $base_url ?>kategori/<?= $d['id'] ?>/<?= $d['slug_kategori'] ?>">
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