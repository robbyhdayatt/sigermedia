<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><b>Tambah Admin</b></div>
            <div class="card-body">
                <form action="" method="POST">
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
                    <input type="text" name="user" class="form-control mb-2" placeholder="Username" required>
                    <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan</button>
                </form>
                <?php
                if(isset($_POST['tambah'])){
                    $nama = $_POST['nama'];
                    $user = $_POST['user'];
                    $pass = md5($_POST['pass']);
                    
                    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'"));
                    if($cek > 0) {
                        echo "<script>alert('Username sudah ada!');</script>";
                    } else {
                        mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap) VALUES ('$user', '$pass', '$nama')");
                        echo "<script>window.location='index.php';</script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><b>Data Users</b></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>No</th><th>Nama</th><th>Username</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php 
                        $no=1; 
                        $q = mysqli_query($koneksi, "SELECT * FROM users");
                        while($r=mysqli_fetch_array($q)){
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['nama_lengkap'] ?></td>
                            <td><?= $r['username'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                <?php if($r['id'] != $_SESSION['user_id']){ ?>
                                <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>