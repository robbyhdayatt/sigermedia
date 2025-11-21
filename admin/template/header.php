<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location:".$base_url."admin/login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siger Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= $base_url ?>admin/index.php">SIGER ADMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/berita/index.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/kategori/index.php">Kategori</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>admin/users/index.php">Users</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                <?= $_SESSION['nama_lengkap'] ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item text-danger" href="<?= $base_url ?>admin/logout.php">Logout</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">