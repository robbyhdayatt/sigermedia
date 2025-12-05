<?php 
include '../config/koneksi.php'; 
include 'template/header.php'; 

$id_user = $_SESSION['user_id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_user'"));

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    if(!empty($pass_lama)){
        // 1. Cek Password Lama (Dukung Hash & MD5)
        $is_valid = false;
        if(password_verify($pass_lama, $data['password'])){
            $is_valid = true;
        } else if(md5($pass_lama) == $data['password']){
            $is_valid = true;
        }

        if($is_valid){
            if($pass_baru == $konfirmasi){
                // 2. Enkripsi Password Baru
                $pass_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
                mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user', password='$pass_hash' WHERE id='$id_user'");
                echo "<script>alert('Profil & Password berhasil diubah! Silakan login ulang.'); window.location='logout.php';</script>";
            } else {
                echo "<script>alert('Password Baru & Konfirmasi tidak sama!');</script>";
            }
        } else {
            echo "<script>alert('Password Lama salah!');</script>";
        }
    } else {
        mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user' WHERE id='$id_user'");
        $_SESSION['nama_lengkap'] = $nama;
        echo "<script>alert('Profil berhasil diupdate!'); window.location='profil.php';</script>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary"><i class="bi bi-person-circle me-2"></i>Profil Saya</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama_lengkap'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-key"></i> Ganti Password</h6>
                    <div class="alert alert-info small py-2">
                        Kosongkan kolom di bawah ini jika tidak ingin mengubah password.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="pass_lama" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="pass_baru" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi" class="form-control">
                        </div>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary w-100 py-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>