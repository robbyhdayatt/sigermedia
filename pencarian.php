<?php include 'includes/header.php'; ?>

<?php
// Tangkap kata kunci dan amankan
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            
            <div class="mb-4 pb-2 border-bottom">
                <h4 class="fw-bold">
                    <i class="bi bi-search"></i> Hasil Pencarian: "<span class="text-primary"><?= htmlspecialchars($keyword) ?></span>"
                </h4>
            </div>

            <?php 
            // PERBAIKAN DISINI: Menambahkan pencarian ke kolom 'tag'
            $query_str = "
                SELECT berita.*, users.nama_lengkap, kategori.nama_kategori 
                FROM berita 
                JOIN users ON berita.id_user = users.id 
                JOIN kategori ON berita.id_kategori = kategori.id
                WHERE 
                    judul LIKE '%$keyword%' 
                    OR isi_berita LIKE '%$keyword%' 
                    OR tag LIKE '%$keyword%'  
                ORDER BY id DESC
            ";
            
            $query = mysqli_query($koneksi, $query_str);

            if(mysqli_num_rows($query) == 0){
                echo "<div class='alert alert-danger text-center py-5 shadow-sm rounded'>";
                echo "<h1 class='display-1 text-muted'><i class='bi bi-emoji-frown'></i></h1>";
                echo "<h4>Maaf, tidak ditemukan berita terkait.</h4>";
                echo "<p class='text-muted'>Coba gunakan kata kunci atau tag lain.</p>";
                echo "</div>";
            }

            while($row = mysqli_fetch_assoc($query)){
            ?>
            
            <div class="card mb-3 border-0 shadow-sm overflow-hidden news-item">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $base_url ?>uploads/<?= $row['gambar'] ?>" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="News">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body py-3">
                            <span class="badge bg-primary mb-2"><?= $row['nama_kategori'] ?></span>
                            
                            <?php if(!empty($row['tag'])): ?>
                                <small class="text-muted ms-2"><i class="bi bi-tags"></i> <?= $row['tag'] ?></small>
                            <?php endif; ?>

                            <h5 class="card-title fw-bold mt-2">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="text-dark text-decoration-none hover-primary"><?= $row['judul'] ?></a>
                            </h5>
                            <p class="card-text text-muted small">
                                <?= substr(strip_tags($row['isi_berita']), 0, 150) ?>...
                            </p>
                            <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
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