<?php 
include '../config/koneksi.php'; 
include 'template/header.php'; 

// Hitung Data Realtime
$jml_berita = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM berita"));
$jml_kategori = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM kategori"));
$jml_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM users"));
$jml_komentar = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM komentar"));
$jml_pending = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM komentar WHERE status_komentar='pending'"));
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="mb-0 text-gray-800 fw-bold">Dashboard Overview</h3>
    <a href="../index.php" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="bi bi-globe me-1"></i> Lihat Website
    </a>
</div>

<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-5 border-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 fw-bold" style="font-size: 0.8rem;">
                            Total Berita</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 fw-bold display-6"><?= $jml_berita ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-newspaper text-gray-300 text-primary" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-5 border-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1 fw-bold" style="font-size: 0.8rem;">
                            Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 fw-bold display-6"><?= $jml_kategori ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tags-fill text-success" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-5 border-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 fw-bold" style="font-size: 0.8rem;">
                            Komentar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 fw-bold display-6"><?= $jml_komentar ?></div>
                        <?php if($jml_pending > 0){ ?>
                            <small class="text-danger fw-bold"><i class="bi bi-exclamation-circle"></i> <?= $jml_pending ?> Pending</small>
                        <?php } ?>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-dots-fill text-warning" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-5 border-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 fw-bold" style="font-size: 0.8rem;">
                            Administrator</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 fw-bold display-6"><?= $jml_user ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill text-info" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Selamat Datang!</h6>
    </div>
    <div class="card-body">
        <div class="text-center py-4">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../assets/images/logo.png" alt="...">
            <h4 class="fw-bold">Halo, <?= $_SESSION['nama_lengkap'] ?></h4>
            <p>Selamat datang kembali di Panel Admin Siger Info Media. Anda memiliki akses penuh untuk mengelola konten berita, kategori, dan komentar.</p>
            <a target="_blank" rel="nofollow" href="../index.php" class="btn btn-outline-primary">Lihat Website &rarr;</a>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>