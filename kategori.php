<?php include 'includes/header.php'; ?>

<?php
// 1. Ambil ID Kategori & Validasi
$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil info kategori untuk Judul Halaman
$query_kat = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id_kategori'");
$kategori_info = mysqli_fetch_assoc($query_kat);

// Jika kategori tidak ditemukan, kembalikan ke Home
if(mysqli_num_rows($query_kat) == 0){
    echo "<script>window.location='".$base_url."';</script>";
    exit;
}

// 2. KONFIGURASI PAGINATION
$batas = 6; // Jumlah berita per halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung Total Data untuk Pagination
$query_total = mysqli_query($koneksi, "SELECT id FROM berita WHERE id_kategori='$id_kategori'");
$jumlah_data = mysqli_num_rows($query_total);
$total_halaman = ceil($jumlah_data / $batas);
?>

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-8">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Kategori</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page"><?= $kategori_info['nama_kategori'] ?></li>
                </ol>
            </nav>

            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                <h3 class="fw-bold mb-0">
                    <i class="bi bi-folder2-open text-primary me-2"></i>
                    <?= $kategori_info['nama_kategori'] ?>
                </h3>
                <span class="badge bg-light text-secondary border ms-3"><?= $jumlah_data ?> Artikel</span>
            </div>

            <?php 
            // 3. QUERY DATA DENGAN LIMIT (Pagination)
            $query = mysqli_query($koneksi, "
                SELECT berita.*, users.nama_lengkap 
                FROM berita 
                JOIN users ON berita.id_user = users.id 
                WHERE id_kategori = '$id_kategori'
                ORDER BY id DESC
                LIMIT $halaman_awal, $batas
            ");

            // Cek Jika Kosong
            if(mysqli_num_rows($query) == 0){
            ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-newspaper text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum ada berita</h5>
                    <p class="text-secondary">Berita pada kategori ini belum tersedia. Silakan cek kategori lainnya.</p>
                    <a href="<?= $base_url ?>" class="btn btn-primary btn-sm rounded-pill px-4">Kembali ke Home</a>
                </div>
            <?php } ?>

            <div class="row">
                <?php while($row = mysqli_fetch_assoc($query)){ ?>
                <div class="col-12 mb-4" data-aos="fade-up">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden hover-shadow transition-all">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative" style="min-height: 200px;">
                                <img src="<?= $base_url ?>uploads/<?= $row['gambar'] ?>" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" alt="<?= $row['judul'] ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4 d-flex flex-column h-100">
                                    <h5 class="card-title fw-bold mb-2">
                                        <a href="<?= $base_url ?>detail/<?= $row['id'] ?>/<?= $row['slug_berita'] ?>" class="text-dark text-decoration-none hover-primary stretched-link">
                                            <?= $row['judul'] ?>
                                        </a>
                                    </h5>
                                    
                                    <div class="text-muted small mb-3 d-flex align-items-center">
                                        <span class="me-3"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($row['tanggal_posting'])) ?></span>
                                        <span><i class="bi bi-eye me-1"></i> <?= number_format($row['views']) ?></span>
                                    </div>

                                    <p class="card-text text-secondary mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= strip_tags($row['isi_berita']) ?>
                                    </p>

                                    <div class="d-flex align-items-center">
                                        <small class="text-primary fw-bold">Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php if($total_halaman > 1){ ?>
            <nav aria-label="Page navigation" class="mt-4 mb-5">
                <ul class="pagination justify-content-center">
                    
                    <li class="page-item <?= ($halaman <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link rounded-pill px-3 mx-1" href="<?= ($halaman > 1) ? '?id='.$id_kategori.'&halaman='.($halaman-1) : '#' ?>">
                            <i class="bi bi-chevron-left"></i> Prev
                        </a>
                    </li>

                    <?php for($x = 1; $x <= $total_halaman; $x++){ ?>
                        <li class="page-item <?= ($halaman == $x) ? 'active' : '' ?>">
                            <a class="page-link rounded-pill px-3 mx-1" href="?id=<?= $id_kategori ?>&halaman=<?= $x ?>">
                                <?= $x ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : '' ?>">
                        <a class="page-link rounded-pill px-3 mx-1" href="<?= ($halaman < $total_halaman) ? '?id='.$id_kategori.'&halaman='.($halaman+1) : '#' ?>">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    
                </ul>
            </nav>
            <?php } ?>

        </div>

        <div class="col-md-4">
            <?php include 'includes/sidebar.php'; ?>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>