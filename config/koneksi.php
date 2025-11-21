<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$database   = "db_siger_media";

$koneksi = mysqli_connect($host, $user, $pass, $database);

if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// BASE URL: Ganti sesuai nama folder di htdocs Anda
// Wajib diakhiri garis miring '/'
$base_url = "http://localhost/sigermedia/";
?>