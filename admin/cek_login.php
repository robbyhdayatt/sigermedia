<?php 
session_start();
include '../config/koneksi.php';
 
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password']; // Password mentah (jangan di-hash dulu)
 
// 1. Cari data berdasarkan Username saja
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
$cek = mysqli_num_rows($query);
 
if($cek > 0){
    $data = mysqli_fetch_assoc($query);
    
    // 2. VERIFIKASI PASSWORD
    // Skenario A: Password sudah modern (Hash)
    if(password_verify($password, $data['password'])) {
        buat_session($data);
    } 
    // Skenario B: Password masih MD5 (Migrasi Otomatis)
    else if(md5($password) == $data['password']) {
        // Enkripsi ulang ke yang aman
        $hash_baru = password_hash($password, PASSWORD_DEFAULT);
        $id_user = $data['id'];
        
        // Update database diam-diam
        mysqli_query($koneksi, "UPDATE users SET password='$hash_baru' WHERE id='$id_user'");
        
        buat_session($data);
    } 
    else {
        // Password salah
        header("location:login.php?pesan=gagal");
    }
} else {
    // Username tidak ditemukan
    header("location:login.php?pesan=gagal");
}

// Fungsi helper biar rapi
function buat_session($row){
    $_SESSION['username'] = $row['username'];
    $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
    $_SESSION['status'] = "login";
    $_SESSION['user_id'] = $row['id'];
    header("location:index.php");
    exit;
}
?>