<?php
// Include koneksi untuk dapatkan variabel $base_url
include '../../config/koneksi.php';
session_start();

// 1. Cek Keamanan: Pastikan user sudah login
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    http_response_code(403);
    echo json_encode(['error' => ['message' => 'Akses ditolak. Silakan login.']]);
    exit;
}

// 2. Proses Upload
if(isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload'];
    $tmp  = $file['tmp_name'];
    $name = $file['name'];
    
    // Validasi Ekstensi
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if(in_array(strtolower($ext), $allowed)) {
        // Buat nama file unik
        $new_name = rand(1000, 9999) . '_' . uniqid() . '.' . $ext;
        
        // Path penyimpanan (Relatif terhadap file ini)
        $destination = '../../uploads/' . $new_name;
        
        if(move_uploaded_file($tmp, $destination)) {
            // 3. Respon JSON Sukses (Wajib format ini untuk CKEditor 5)
            echo json_encode([
                'url' => $base_url . 'uploads/' . $new_name
            ]);
        } else {
            echo json_encode(['error' => ['message' => 'Gagal memindahkan file ke server.']]);
        }
    } else {
        echo json_encode(['error' => ['message' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.']]);
    }
}
?>