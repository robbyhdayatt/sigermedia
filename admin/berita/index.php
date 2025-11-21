<?php 
// Naik 2 level untuk akses config dan template
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Data Berita</h5>
        <a href="tambah.php" class="btn btn-primary btn-sm">+ Tambah Berita</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT berita.*, kategori.nama_kategori FROM berita JOIN kategori ON berita.id_kategori = kategori.id ORDER BY berita.id DESC");
                while($row = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td width="5%"><?= $no++; ?></td>
                    <td width="15%">
                        <img src="<?= $base_url ?>uploads/<?= $row['gambar'] ?>" width="80" class="rounded">
                    </td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['nama_kategori'] ?></td>
                    <td width="15%">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../template/footer.php'; ?>