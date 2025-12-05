<?php
include '../../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT gambar FROM iklan WHERE id='$id'"));

// Hapus file fisik
if(file_exists('../../uploads/iklan/' . $data['gambar'])){
    unlink('../../uploads/iklan/' . $data['gambar']);
}

mysqli_query($koneksi, "DELETE FROM iklan WHERE id='$id'");
header("location:index.php");
?>