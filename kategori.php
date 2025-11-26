<?php include 'includes/header.php'; ?>

<?php
// 1. Ambil ID Kategori dari URL
$id_kategori = $_GET['id'];

// 2. Ambil Nama Kategori (untuk Judul Halaman)
$query_kat = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id_kategori'");
$kategori_info = mysqli_fetch_assoc($query_kat);

// Cek jika kategori tidak ditemukan (misal user iseng ganti ID di URL)
if(mysqli_num_rows($query_kat) == 0){
    echo "<script>window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-8">
            
            <div class="mb-4 pb-2 border-bottom">
                <h4 class="fw-bold">
                    Kategori: <span class="text-primary"><?= $kategori_info['nama_kategori'] ?></span>
                </h4>
            </div>

            <?php 
            // 3. Ambil Berita berdasarkan Kategori
            $query = mysqli_query($koneksi, "
                SELECT berita.*, users.nama_lengkap, kategori.nama_kategori 
                FROM berita 
                JOIN users ON berita.id_user = users.id 
                JOIN kategori ON berita.id_kategori = kategori.id
                WHERE id_kategori = '$id_kategori'
                ORDER BY id DESC
            ");

            // Cek jika belum ada berita di kategori ini
            if(mysqli_num_rows($query) == 0){
                echo "<div class='alert alert-warning'>Belum ada berita pada kategori ini.</div>";
            }

            while($row = mysqli_fetch_assoc($query)){
            ?>
            
            <div class="news-item d-flex align-items-start">
                <div class="row g-0 w-100">
                    <div class="col-4 col-md-4">
                        <img src="<?= $base_url ?>uploads/<?= $row['gambar'] ?>" class="news-thumb" alt="News">
                    </div>
                    <div class="col-8 col-md-8 ps-3">
                        <span class="badge bg-light text-primary mb-1 border"><?= $row['nama_kategori'] ?></span>
                        <h5 class="fw-bold mt-1 mb-1">
                            <a href="detail.php?id=<?= $row['id'] ?>" class="text-dark"><?= $row['judul'] ?></a>
                        </h5>
                        <div class="text-muted small mb-2">
                            <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($row['tanggal_posting'])) ?> &bull; 
                            <i class="bi bi-person"></i> <?= $row['nama_lengkap'] ?>
                        </div>
                        <p class="text-muted small d-none d-md-block">
                            <?= substr(strip_tags($row['isi_berita']), 0, 100) ?>...
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>

        <div class="col-md-4">
            <?php include 'includes/sidebar.php'; ?>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>