<?php
if(session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    // Gunakan script location agar tidak error header already sent
    echo "<script>window.location='../login.php?pesan=belum_login';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siger Admin Panel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }
        /* SIDEBAR STYLE */
        #sidebar-wrapper {
            min-height: 100vh;
            width: var(--sidebar-width);
            margin-left: -var(--sidebar-width);
            transition: margin .25s ease-out;
            position: fixed;
            z-index: 1000;
            background: #212529; /* Dark Sidebar */
        }
        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.25rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            text-align: center;
            letter-spacing: 1px;
            background: rgba(0,0,0,0.1);
        }
        #sidebar-wrapper .list-group { width: var(--sidebar-width); }
        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            background-color: transparent;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            transition: all 0.2s;
        }
        .list-group-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            padding-left: 1.8rem; /* Efek geser saat hover */
        }
        .list-group-item.active {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 600;
        }
        .list-group-item i { margin-right: 10px; width: 20px; text-align: center; }

        /* CONTENT WRAPPER */
        #page-content-wrapper {
            width: 100%;
            transition: margin .25s ease-out;
        }
        
        /* RESPONSIVE LOGIC */
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { margin-left: var(--sidebar-width); }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -var(--sidebar-width); }
            body.sb-sidenav-toggled #page-content-wrapper { margin-left: 0; }
        }
        
        /* CARD STYLE */
        .card { border: none; border-radius: 10px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .card-header { background-color: #fff; border-bottom: 1px solid #e3e6f0; font-weight: 700; color: var(--primary-color); }
        
        /* NAVBAR STYLE */
        .top-navbar { background: white; box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    
    <div class="bg-dark border-end" id="sidebar-wrapper">
        <div class="sidebar-heading text-uppercase">
            <i class="bi bi-exclude me-2"></i> Siger Admin
        </div>
        <div class="list-group list-group-flush mt-3">
            <a href="<?= $base_url ?>admin/index.php" class="list-group-item list-group-item-action <?= basename($_SERVER['PHP_SELF']) == 'index.php' && strpos($_SERVER['REQUEST_URI'], 'berita') === false && strpos($_SERVER['REQUEST_URI'], 'kategori') === false && strpos($_SERVER['REQUEST_URI'], 'users') === false && strpos($_SERVER['REQUEST_URI'], 'komentar') === false ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?= $base_url ?>admin/berita/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/berita/') !== false ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Berita
            </a>
            <a href="<?= $base_url ?>admin/kategori/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/kategori/') !== false ? 'active' : '' ?>">
                <i class="bi bi-tags-fill"></i> Kategori
            </a>
            
            <?php 
            $cek_pending = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM komentar WHERE status_komentar='pending'"));
            ?>
            <a href="<?= $base_url ?>admin/komentar/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/komentar/') !== false ? 'active' : '' ?>">
                <i class="bi bi-chat-dots-fill"></i> Komentar
                <?php if($cek_pending > 0){ ?>
                    <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 0.7rem;"><?= $cek_pending ?></span>
                <?php } ?>
            </a>

            <a href="<?= $base_url ?>admin/iklan/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/iklan/') !== false ? 'active' : '' ?>">
                <i class="bi bi-badge-ad-fill"></i> Iklan / Banner
            </a>

            <a href="<?= $base_url ?>admin/users/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/users/') !== false ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Users
            </a>
            <div class="sidebar-heading text-uppercase mt-3" style="font-size: 0.75rem;">
                Pengaturan
            </div>
            
            <a href="<?= $base_url ?>admin/identitas/index.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], '/identitas/') !== false ? 'active' : '' ?>">
                <i class="bi bi-gear-wide-connected"></i> Website
            </a>
            
            <a href="<?= $base_url ?>admin/profil.php" class="list-group-item list-group-item-action <?= strpos($_SERVER['REQUEST_URI'], 'profil.php') !== false ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i> Profil Saya
            </a>
            <a href="<?= $base_url ?>admin/logout.php" class="list-group-item list-group-item-action text-danger mt-4 border-top border-secondary pt-3">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <div id="page-content-wrapper">
        
        <nav class="navbar navbar-expand-lg navbar-light top-navbar mb-4 py-3">
            <div class="container-fluid px-4">
                <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-dark d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <?= isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Admin' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= $base_url ?>admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid px-4 pb-5">