<div class="sidebar-widget shadow-sm bg-white mb-4 border rounded p-4">
    <h5 class="widget-title fw-bold border-bottom pb-2 mb-3">Cari Berita</h5>
    <form action="<?= $base_url ?>pencarian.php" method="GET">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Ketik kata kunci..." required>
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>
</div>

<div class="sidebar-widget shadow-sm bg-white mb-4 border rounded p-4">
    <h5 class="widget-title fw-bold border-bottom pb-2 mb-3">Terpopuler</h5>
    <?php 
    // Query berita terpopuler
    $pop = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY views DESC LIMIT 5");
    $nomor = 1;
    while($p = mysqli_fetch_assoc($pop)){
    ?>
    <div class="d-flex align-items-center mb-3 pb-2 border-bottom border-light">
        <div class="fw-bold text-secondary me-3" style="font-size: 1.5rem;"><?= $nomor++ ?></div>
        <div>
            <h6 class="mb-1 fw-bold" style="font-size: 0.9rem; line-height: 1.4;">
                <a href="<?= $base_url ?>detail/<?= $p['id'] ?>/<?= $p['slug_berita'] ?>" class="text-dark text-decoration-none"><?= $p['judul'] ?></a>
            </h6>
            <small class="text-muted" style="font-size: 0.75rem;"><?= number_format($p['views']) ?> x dibaca</small>
        </div>
    </div>
    <?php } ?>
</div>

<div class="sidebar-widget shadow-sm bg-white mb-4 border rounded p-4">
    <h5 class="widget-title fw-bold border-bottom pb-2 mb-3">Topik Pilihan</h5>
    <div class="d-flex flex-wrap gap-2">
        <?php 
        $kats = mysqli_query($koneksi, "SELECT * FROM kategori");
        while($k = mysqli_fetch_assoc($kats)){
        ?>
        <a href="<?= $base_url ?>kategori/<?= $k['id'] ?>/<?= $k['slug_kategori'] ?>" class="btn btn-light btn-sm border"><?= $k['nama_kategori'] ?></a>
        <?php } ?>
    </div>
</div>

<div class="sidebar-widget shadow-sm bg-white mb-4 border rounded p-3 text-center">
    <small class="text-muted fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">SPONSORED</small>
    
    <?php 
    // Ambil iklan yang statusnya 'aktif'
    $q_iklan = mysqli_query($koneksi, "SELECT * FROM iklan WHERE status='aktif' ORDER BY id DESC");
    
    if(mysqli_num_rows($q_iklan) > 0){
        while($ads = mysqli_fetch_assoc($q_iklan)){
    ?>
        <div class="mb-3">
            <a href="<?= $ads['link'] ?>" target="_blank" title="<?= $ads['judul'] ?>">
                <img src="<?= $base_url ?>uploads/iklan/<?= $ads['gambar'] ?>" class="img-fluid rounded border hover-shadow" alt="<?= $ads['judul'] ?>">
            </a>
        </div>
    <?php 
        } 
    } else {
        // Jika tidak ada iklan aktif, tampilkan placeholder default
    ?>
        <div class="bg-light p-4 rounded border text-muted">
            <i class="bi bi-info-circle mb-2" style="font-size: 2rem;"></i><br>
            <span>Pasang Iklan Disini</span><br>
            <small>Hubungi Admin</small>
        </div>
    <?php } ?>
</div>