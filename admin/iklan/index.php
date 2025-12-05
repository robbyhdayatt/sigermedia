<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold text-primary"><i class="bi bi-badge-ad"></i> Manajemen Iklan</h4>
    <a href="tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Iklan</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Preview</th>
                        <th>Info Iklan</th>
                        <th width="15%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM iklan ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($query)){
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <img src="../../uploads/iklan/<?= $row['gambar'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                        </td>
                        <td>
                            <strong class="text-dark"><?= $row['judul'] ?></strong><br>
                            <small class="text-muted"><i class="bi bi-link-45deg"></i> <?= substr($row['link'], 0, 30) ?>...</small>
                        </td>
                        <td>
                            <?php if($row['status'] == 'aktif'){ ?>
                                <span class="badge bg-success">Tayang</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil"></i></a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus iklan ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>