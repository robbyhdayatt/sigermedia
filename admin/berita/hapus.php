<?php
include '../../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id'"));

// Hapus file gambar fisik
if(file_exists('../../uploads/' . $data['gambar'])){
    unlink('../../uploads/' . $data['gambar']);
}

// Hapus data database
mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
header("location:index.php");
?>