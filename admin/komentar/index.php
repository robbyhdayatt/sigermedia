<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Moderasi Komentar</h5>
    </div>
    <div class="card-body">
        
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active fw-bold" href="index.php">Semua Komentar</a>
            </li>
        </ul>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th width="40%">Isi Komentar</th>
                        <th>Pada Berita</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($koneksi, "
                        SELECT komentar.*, berita.judul 
                        FROM komentar 
                        JOIN berita ON komentar.id_berita = berita.id 
                        ORDER BY komentar.id DESC
                    ");
                    
                    while($row = mysqli_fetch_assoc($query)){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['nama_pengirim']) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small><br>
                            <small class="text-muted" style="font-size:11px"><?= date('d/m/Y H:i', strtotime($row['tanggal_komentar'])) ?></small>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['isi_komentar'])) ?></td>
                        <td>
                            <a href="<?= $base_url ?>detail.php?id=<?= $row['id_berita'] ?>" target="_blank" class="text-decoration-none small">
                                <?= substr($row['judul'], 0, 30) ?>... <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>
                        <td>
                            <?php if($row['status_komentar'] == 'pending'){ ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php } else { ?>
                                <span class="badge bg-success">Tayang</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($row['status_komentar'] == 'pending'){ ?>
                                <a href="proses.php?act=approve&id=<?= $row['id'] ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Tampilkan komentar ini?')">
                                    <i class="bi bi-check-lg"></i> Terima
                                </a>
                            <?php } else { ?>
                                <a href="proses.php?act=pending&id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm mb-1">
                                    <i class="bi bi-eye-slash"></i> Sembunyi
                                </a>
                            <?php } ?>
                            
                            <a href="proses.php?act=hapus&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus permanen?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>