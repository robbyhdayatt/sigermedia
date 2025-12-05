<?php include 'includes/header.php'; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Logika Komentar
if(isset($_POST['kirim_komentar'])){
    $nama   = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
    $email  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['email']));
    $isi    = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['isi']));
    $id_brt = $_POST['id_berita'];

    if(!empty($nama) && !empty($isi)){
        $simpan = mysqli_query($koneksi, "INSERT INTO komentar (id_berita, nama_pengirim, email, isi_komentar, status_komentar) VALUES ('$id_brt', '$nama', '$email', '$isi', 'pending')");
        if($simpan){
            $cek_slug = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT slug_berita FROM berita WHERE id='$id_brt'"));
            $slug_redirect = $cek_slug['slug_berita'];
            echo "<script>alert('Terima kasih! Komentar Anda menunggu moderasi.'); window.location='".$base_url."detail/$id/$slug_redirect';</script>";
        }
    }
}

// Update Views
mysqli_query($koneksi, "UPDATE berita SET views = views + 1 WHERE id = '$id'");

// Query Detail Berita
$query = mysqli_query($koneksi, "
    SELECT berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama_lengkap 
    FROM berita 
    JOIN kategori ON berita.id_kategori = kategori.id
    JOIN users ON berita.id_user = users.id
    WHERE berita.id = '$id'
");

if(mysqli_num_rows($query) == 0){
    echo "<script>window.location='".$base_url."';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
$current_url = $base_url . "detail/" . $data['id'] . "/" . $data['slug_berita'];
?>

<div class="container mt-4">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="<?= $base_url ?>" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $base_url ?>kategori/<?= $data['id_kategori'] ?>/<?= $data['slug_kategori'] ?>" class="text-decoration-none"><?= $data['nama_kategori'] ?></a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 300px;"><?= $data['judul'] ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8" data-aos="fade-up">
            
            <h1 class="fw-bold mb-3 lh-base"><?= $data['judul'] ?></h1>
            <div class="d-flex align-items-center mb-4 text-muted small border-bottom pb-3">
                <span class="me-3"><i class="bi bi-person-circle"></i> <?= $data['nama_lengkap'] ?></span>
                <span class="me-3"><i class="bi bi-calendar3"></i> <?= date('d F Y', strtotime($data['tanggal_posting'])) ?></span>
                <span><i class="bi bi-eye"></i> <?= number_format($data['views']) ?> dilihat</span>
            </div>

            <img src="<?= $base_url ?>uploads/<?= $data['gambar'] ?>" class="img-fluid rounded w-100 mb-4 shadow-sm" alt="Gambar Berita">

            <article class="fs-5 lh-lg text-break mb-5 berita-content">
                <?= $data['isi_berita']; ?>
            </article>

            <?php 
            // Pastikan kolom di database namanya 'tag'. Jika 'tags', ganti $data['tags']
            if(!empty($data['tag'])){ 
            ?>
            <div class="mb-4">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-bold text-muted small"><i class="bi bi-tags-fill me-1"></i> Tags:</span>
                    <?php
                    // Pecah string tag berdasarkan koma (misal: "politik, lampung" jadi array)
                    $tags = explode(',', $data['tag']);
                    foreach($tags as $t){
                        $t = trim($t); // Hilangkan spasi kiri/kanan
                        if(!empty($t)){
                    ?>
                        <a href="<?= $base_url ?>pencarian.php?keyword=<?= urlencode($t) ?>" class="btn btn-sm btn-light border rounded-pill text-secondary hover-primary" style="font-size: 0.85rem;">
                            #<?= $t ?>
                        </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php } ?>

            <div class="mb-5 p-4 bg-light rounded border">
                <h6 class="fw-bold mb-3">Bagikan Berita Ini:</h6>
                <div class="d-flex gap-2">
                    <a href="https://wa.me/?text=<?= urlencode($data['judul'] . " - " . $current_url) ?>" target="_blank" class="btn btn-success flex-fill">
                        <i class="bi bi-whatsapp me-2"></i> <span class="d-none d-md-inline">WhatsApp</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($current_url) ?>" target="_blank" class="btn btn-primary flex-fill">
                        <i class="bi bi-facebook me-2"></i> <span class="d-none d-md-inline">Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($data['judul']) ?>&url=<?= urlencode($current_url) ?>" target="_blank" class="btn btn-dark flex-fill">
                        <i class="bi bi-twitter-x me-2"></i> <span class="d-none d-md-inline">Twitter</span>
                    </a>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="fw-bold border-bottom pb-2 mb-4">Berita Terkait</h4>
                <div class="row">
                    <?php 
                    // Query berita lain di kategori yang sama, kecuali berita ini sendiri
                    $id_kat = $data['id_kategori'];
                    $q_terkait = mysqli_query($koneksi, "
                        SELECT * FROM berita 
                        WHERE id_kategori='$id_kat' AND id != '$id' 
                        ORDER BY id DESC LIMIT 3
                    ");

                    if(mysqli_num_rows($q_terkait) > 0){
                        while($rel = mysqli_fetch_assoc($q_terkait)){
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="<?= $base_url ?>uploads/<?= $rel['gambar'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold" style="font-size: 0.95rem;">
                                    <a href="<?= $base_url ?>detail/<?= $rel['id'] ?>/<?= $rel['slug_berita'] ?>" class="text-dark text-decoration-none hover-primary">
                                        <?= $rel['judul'] ?>
                                    </a>
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar"></i> <?= date('d M Y', strtotime($rel['tanggal_posting'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php 
                        } // End while
                    } else {
                        echo "<div class='col-12'><p class='text-muted'>Belum ada berita terkait lainnya.</p></div>";
                    }
                    ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-white mb-5" id="kolom-komentar">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Komentar Pembaca</h4>

                    <div class="bg-light p-3 rounded mb-4 border">
                        <h6 class="fw-bold mb-3"><i class="bi bi-chat-dots"></i> Tulis Komentar</h6>
                        <form action="" method="POST">
                            <input type="hidden" name="id_berita" value="<?= $id ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email (Tidak akan dipublish)" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea name="isi" class="form-control" rows="3" placeholder="Tulis pendapat Anda di sini..." required></textarea>
                            </div>
                            <button type="submit" name="kirim_komentar" class="btn btn-primary px-4">Kirim Komentar</button>
                        </form>
                    </div>

                    <div class="list-komentar">
                        <?php 
                        // Hanya ambil yang status='published'
                        $q_komentar = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_berita='$id' AND status_komentar='published' ORDER BY id DESC");
                        $jml_komen = mysqli_num_rows($q_komentar);

                        if($jml_komen == 0){
                            echo "<p class='text-center text-muted fst-italic py-3'>Belum ada komentar.</p>";
                        } else {
                            while($k = mysqli_fetch_assoc($q_komentar)){
                                $inisial = substr($k['nama_pengirim'], 0, 1);
                        ?>
                        <div class="d-flex mb-4 border-bottom pb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 20px;">
                                    <?= strtoupper($inisial) ?>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mt-0 fw-bold mb-0">
                                    <?= htmlspecialchars($k['nama_pengirim']) ?>
                                    <small class="text-muted fw-normal ms-2" style="font-size: 12px;">
                                        <?= date('d M Y, H:i', strtotime($k['tanggal_komentar'])) ?>
                                    </small>
                                </h6>
                                <p class="mb-0 text-dark mt-1">
                                    <?= nl2br(htmlspecialchars($k['isi_komentar'])) ?>
                                </p>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>

                </div>
            </div>
            </div>

        <div class="col-md-4" data-aos="fade-left">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>