<?php include 'includes/header.php'; ?>

<?php
// Tangkap kata kunci dari form (amankan dari karakter aneh)
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            
            <div class="mb-4 pb-2 border-bottom">
                <h4 class="fw-bold">
                    Hasil Pencarian: "<span class="text-primary"><?= htmlspecialchars($keyword) ?></span>"
                </h4>
            </div>

            <?php 
            // Query Pencarian (Mencari di Judul ATAU di Isi Berita)
            $query = mysqli_query($koneksi, "
                SELECT berita.*, users.nama_lengkap, kategori.nama_kategori 
                FROM berita 
                JOIN users ON berita.id_user = users.id 
                JOIN kategori ON berita.id_kategori = kategori.id
                WHERE judul LIKE '%$keyword%' OR isi_berita LIKE '%$keyword%'
                ORDER BY id DESC
            ");

            if(mysqli_num_rows($query) == 0){
                echo "<div class='alert alert-danger text-center py-5'>";
                echo "<h4><i class='bi bi-emoji-frown'></i> Maaf, berita tidak ditemukan.</h4>";
                echo "<p>Coba gunakan kata kunci lain.</p>";
                echo "</div>";
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