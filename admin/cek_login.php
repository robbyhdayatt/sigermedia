<?php 
// Mengaktifkan session php
session_start();
 
// Menghubungkan dengan koneksi
include '../config/koneksi.php';
 
// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']); // Enkripsi MD5 sesuai data dummy tadi
 
// Menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
 
// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
 
if($cek > 0){
    $row = mysqli_fetch_assoc($data);

    // Menyimpan data user dalam session
    $_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
    $_SESSION['status'] = "login";
    $_SESSION['user_id'] = $row['id']; // Penting untuk mencatat siapa yang posting berita
 
    // Alihkan ke halaman dashboard admin
    header("location:index.php");
}else{
    // Jika gagal, alihkan kembali ke halaman login dengan pesan gagal
    header("location:login.php?pesan=gagal");
}
?>