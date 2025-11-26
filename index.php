<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    
    <?php 
    $headline_q = mysqli_query($koneksi, "SELECT berita.*, kategori.nama_kategori FROM berita JOIN kategori ON berita.id_kategori = kategori.id ORDER BY berita.id DESC LIMIT 1");
    if(mysqli_num_rows($headline_q) > 0){
        $hl = mysqli_fetch_assoc($headline_q);
    ?>
    <div class="row mb-5">
        <div class="col-12">
            
            <?php 
            // Ambil 3 Berita Terbaru
            $slider_q = mysqli_query($koneksi, "SELECT berita.*, kategori.nama_kategori FROM berita JOIN kategori ON berita.id_kategori = kategori.id ORDER BY berita.id DESC LIMIT 3");
            $slides = [];
            while($s = mysqli_fetch_assoc($slider_q)){ $slides[] = $s; }
            ?>

            <div id="heroCarousel" class="carousel slide hero-slider-area" data-bs-ride="carousel" data-aos="zoom-in">
                
                <div class="carousel-indicators mb-4">
                    <?php foreach($slides as $i => $sl): ?>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" 
                            class="<?= ($i==0)?'active':'' ?>" style="width: 30px; height: 4px; border-radius: 2px;"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner">
                    <?php foreach($slides as $i => $sl): ?>
                    <div class="carousel-item <?= ($i==0)?'active':'' ?>" data-bs-interval="6000"> <div class="hero-img-wrapper">
                            <img src="<?= $base_url ?>uploads/<?= $sl['gambar'] ?>" class="hero-img" alt="<?= $sl['judul'] ?>">
                        </div>

                        <div class="carousel-caption text-start glass-caption">
                            <span class="badge bg-primary mb-2 animate__animated animate__fadeInDown"><?= $sl['nama_kategori'] ?></span>
                            
                            <h2 class="fw-bold text-white hero-title animate__animated animate__fadeInUp" style="line-height: 1.3;">
                                <a href="detail.php?id=<?= $sl['id'] ?>" class="text-white text-decoration-none hover-underline">
                                    <?= $sl['judul'] ?>
                                </a>
                            </h2>
                            
                            <p class="text-light mb-3 d-none d-md-block animate__animated animate__fadeInUp animate__delay-1s" style="opacity: 0.9;">
                                <?= substr(strip_tags($sl['isi_berita']), 0, 120) ?>...
                            </p>

                            <a href="detail.php?id=<?= $sl['id'] ?>" class="btn btn-sm btn-outline-light rounded-pill px-4 animate__animated animate__fadeInUp">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev custom-nav-btn ms-3" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next custom-nav-btn me-3" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>

            </div>

        </div>
    </div>
    <?php } ?>

    <div class="row">
        
        <div class="col-md-8">
            <h4 class="widget-title text-dark border-bottom pb-2 mb-4">
                <span class="border-bottom border-3 border-primary pb-2">Berita Terbaru</span>
            </h4>
            
            <?php 
            // --- LOGIKA PAGINATION ---
            $batas = 5; 
            $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
            $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

            // OFFSET: Lewati 3 data pertama (karena ada di Slider Headline)
            $offset_total = $halaman_awal + 3; 

            // Query Data
            $query_string = "SELECT berita.*, kategori.nama_kategori FROM berita JOIN kategori ON berita.id_kategori = kategori.id ORDER BY berita.id DESC LIMIT $batas OFFSET $offset_total";
            $query = mysqli_query($koneksi, $query_string);
            
            // Hitung Total Halaman
            $data_total = mysqli_query($koneksi, "SELECT id FROM berita");
            $jumlah_data = mysqli_num_rows($data_total) - 3; 
            if($jumlah_data < 0) $jumlah_data = 0;
            $total_halaman = ceil($jumlah_data / $batas);

            while($row = mysqli_fetch_assoc($query)){
            ?>
            
            <div class="news-item card mb-4 border-0 shadow-sm" data-aos="fade-up">
                <div class="row g-0">
                    <div class="col-md-4 position-relative overflow-hidden">
                        <img src="<?= $base_url ?>uploads/<?= $row['gambar'] ?>" class="news-thumb h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="<?= $row['judul'] ?>">
                        <span class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1 m-2 rounded small fw-bold" style="font-size: 0.7rem;">
                            <?= $row['nama_kategori'] ?>
                        </span>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body py-3 px-4 d-flex flex-column h-100 justify-content-center">
                            
                            <h5 class="card-title fw-bold mb-2">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="text-dark text-decoration-none hover-primary">
                                    <?= $row['judul'] ?>
                                </a>
                            </h5>

                            <div class="text-muted small mb-3">
                                <span class="me-3">
                                    <i class="bi bi-calendar3 me-1"></i> 
                                    <?= date('d M Y', strtotime($row['tanggal_posting'])) ?>
                                </span>
                                <span>
                                    <i class="bi bi-eye-fill me-1 text-primary"></i> 
                                    <?= number_format($row['views']) ?> dilihat
                                </span>
                            </div>

                            <p class="card-text text-secondary mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                <?php 
                                // strip_tags: Hapus tag HTML dari CKEditor agar tampilan rapi
                                // substr: Potong jadi 130 karakter
                                $isi_bersih = strip_tags($row['isi_berita']);
                                echo substr($isi_bersih, 0, 130) . "..."; 
                                ?>
                            </p>

                            <div class="mt-3">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="text-primary fw-bold text-decoration-none small">
                                    Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <nav aria-label="Page navigation" class="mt-5 mb-5" data-aos="fade-up">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($halaman <= 1) echo 'disabled'; ?>">
                        <a class="page-link rounded-pill px-3 mx-1" href="<?php if($halaman > 1) echo "?halaman=".($halaman-1); ?>">Previous</a>
                    </li>
                    <?php for($x = 1; $x <= $total_halaman; $x++){ ?>
                        <li class="page-item <?php if($halaman == $x) echo 'active'; ?>">
                            <a class="page-link rounded-pill px-3 mx-1" href="?halaman=<?= $x ?>"><?= $x ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php if($halaman >= $total_halaman) echo 'disabled'; ?>">
                        <a class="page-link rounded-pill px-3 mx-1" href="<?php if($halaman < $total_halaman) echo "?halaman=".($halaman+1); ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
            
            <?php include 'includes/sidebar.php'; ?>
            
        </div>
        </div> </div> <?php include 'includes/footer.php'; ?>