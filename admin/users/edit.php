<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
$id = $_GET['id'];
$d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));
?>

<div class="card border-0 shadow-sm col-md-6 mx-auto">
    <div class="card-header bg-white"><b>Edit User</b></div>
    <div class="card-body">
        <form action="" method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control mb-2" value="<?= $d['nama_lengkap'] ?>">
            <label>Username</label>
            <input type="text" name="user" class="form-control mb-2" value="<?= $d['username'] ?>">
            <label>Password (Kosongkan jika tidak diganti)</label>
            <input type="password" name="pass" class="form-control mb-3">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
        <?php
        if(isset($_POST['update'])){
            $nama = $_POST['nama'];
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            
            if(!empty($pass)){
                $pass_hash = md5($pass);
                mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user', password='$pass_hash' WHERE id='$id'");
            } else {
                mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$user' WHERE id='$id'");
            }
            echo "<script>window.location='index.php';</script>";
        }
        ?>
    </div>
</div>

<?php include '../template/footer.php'; ?>