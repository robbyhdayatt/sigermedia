<?php
session_start();
include '../../config/koneksi.php';

$id = $_GET['id'];
if($id == $_SESSION['user_id']){
    echo "<script>alert('Tidak bisa menghapus diri sendiri!'); window.location='index.php';</script>";
    exit;
}

mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
header("location:index.php");
?>