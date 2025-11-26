<?php include 'includes/header.php'; ?>

<?php
// 1. Tangkap ID Berita
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. LOGIKA MENYIMPAN KOMENTAR (Diletakkan di atas agar bisa redirect)
if(isset($_POST['kirim_komentar'])){
    // Amankan input dari karakter berbahaya (XSS & SQL Injection)
    $nama   = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
    $email  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['email']));
    $isi    = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['isi']));
    $id_brt = $_POST['id_berita'];

    if(!empty($nama) && !empty($isi)){
        $simpan = mysqli_query($koneksi, "INSERT INTO komentar (id_berita, nama_pengirim, email, isi_komentar) VALUES ('$id_brt', '$nama', '$email', '$isi')");
        if($simpan){
            // Redirect ke halaman yang sama agar form ter-reset
            echo "<script>alert('Komentar berhasil dikirim!'); window.location='detail.php?id=$id';</script>";
        }
    }
}

// 3. Update View Counter
mysqli_query($koneksi, "UPDATE berita SET views = views + 1 WHERE id = '$id'");

// 4. Ambil Data Detail Berita
$query = mysqli_query($koneksi, "
    SELECT berita.*, kategori.nama_kategori, users.nama_lengkap 
    FROM berita 
    JOIN kategori ON berita.id_kategori = kategori.id
    JOIN users ON berita.id_user = users.id
    WHERE berita.id = '$id'
");

if(mysqli_num_rows($query) == 0){
    echo "<script>window.location='index.php';</script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<div class="container mt-4">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="kategori.php?id=<?= $data['id_kategori'] ?>" class="text-decoration-none"><?= $data['nama_kategori'] ?></a></li>
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
                        // Ambil komentar khusus untuk berita ini (id_berita = $id)
                        $q_komentar = mysqli_query($koneksi, "SELECT * FROM komentar WHERE id_berita='$id' ORDER BY id DESC");
                        $jml_komen = mysqli_num_rows($q_komentar);

                        if($jml_komen == 0){
                            echo "<p class='text-center text-muted fst-italic py-3'>Belum ada komentar. Jadilah yang pertama!</p>";
                        } else {
                            while($k = mysqli_fetch_assoc($q_komentar)){
                                // Bikin Avatar dummy pakai inisial nama
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
                        <?php 
                            } // end while
                        } // end else
                        ?>
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