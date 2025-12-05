<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $d['nama_lengkap'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="user" class="form-control" value="<?= $d['username'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="pass" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                        <small class="text-muted">Isi hanya jika ingin mereset password user ini.</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
                <?php
                if(isset($_POST['update'])){
                    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
                    $pass = $_POST['pass'];
                    
                    if(!empty($pass)){
                        // UPDATE SECURITY
                        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
                        mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user', password='$pass_hash' WHERE id='$id'");
                    } else {
                        mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user' WHERE id='$id'");
                    }
                    echo "<script>window.location='index.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>