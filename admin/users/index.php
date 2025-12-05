<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-person-plus me-2"></i>Tambah Admin</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="user" class="form-control" placeholder="Tanpa spasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan Data</button>
                </form>
                <?php
                if(isset($_POST['tambah'])){
                    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
                    // UPDATE SECURITY: Gunakan password_hash
                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    
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
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-table me-2"></i>Data Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="bg-light">
                            <tr><th>No</th><th>Nama</th><th>Username</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=1; 
                            $q = mysqli_query($koneksi, "SELECT * FROM users");
                            while($r=mysqli_fetch_array($q)){
                            ?>
                            <tr>
                                <td width="5%"><?= $no++ ?></td>
                                <td><?= $r['nama_lengkap'] ?></td>
                                <td><?= $r['username'] ?></td>
                                <td width="20%">
                                    <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil-square"></i></a>
                                    <?php if($r['id'] != $_SESSION['user_id']){ ?>
                                    <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash"></i></a>
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
</div>

<?php include '../template/footer.php'; ?>