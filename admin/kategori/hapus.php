<?php
include '../../config/koneksi.php';
mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$_GET[id]'");
header("location:index.php");
?>