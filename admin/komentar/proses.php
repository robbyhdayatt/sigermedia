<?php
session_start();
include '../../config/koneksi.php';

// Cek Login Admin
if($_SESSION['status'] != "login"){
    header("location:../../admin/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$act = isset($_GET['act']) ? $_GET['act'] : '';

if($act == "approve"){
    // Ubah status jadi published
    mysqli_query($koneksi, "UPDATE komentar SET status_komentar='published' WHERE id='$id'");
    echo "<script>alert('Komentar berhasil ditayangkan!'); window.location='index.php';</script>";

} elseif($act == "pending"){
    // Ubah status jadi pending (sembunyikan)
    mysqli_query($koneksi, "UPDATE komentar SET status_komentar='pending' WHERE id='$id'");
    echo "<script>window.location='index.php';</script>";

} elseif($act == "hapus"){
    // Hapus permanen
    mysqli_query($koneksi, "DELETE FROM komentar WHERE id='$id'");
    echo "<script>window.location='index.php';</script>";
}
?>