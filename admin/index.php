<?php 
// Include koneksi dulu baru header
include '../config/koneksi.php'; 
include 'template/header.php'; 
?>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3>Selamat Datang, <?= $_SESSION['nama_lengkap'] ?>!</h3>
                <p class="text-muted">Ini adalah halaman dashboard utama Siger Info Media.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5>Total Berita</h5>
                <h2><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM berita")); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5>Total Kategori</h5>
                <h2><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kategori")); ?></h2>
            </div>
        </div>
    </div>
     <div class="col-md-4">
        <div class="card bg-warning text-dark mb-3">
            <div class="card-body">
                <h5>Total User</h5>
                <h2><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users")); ?></h2>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>