<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><b>Tambah Kategori</b></div>
            <div class="card-body">
                <form action="" method="POST">
                    <input type="text" name="nama" class="form-control mb-3" placeholder="Nama Kategori" required>
                    <button type="submit" name="tambah" class="btn btn-primary w-100">Simpan</button>
                </form>
                <?php
                if(isset($_POST['tambah'])){
                    $nama = $_POST['nama'];
                    $slug = strtolower(str_replace(' ', '-', $nama));
                    mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori, slug_kategori) VALUES ('$nama', '$slug')");
                    echo "<script>window.location='index.php';</script>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><b>Data Kategori</b></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead><tr><th>No</th><th>Kategori</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php 
                        $no=1; 
                        $q = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
                        while($r=mysqli_fetch_array($q)){
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['nama_kategori'] ?></td>
                            <td><a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>