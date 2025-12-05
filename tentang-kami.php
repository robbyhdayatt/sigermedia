<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-8">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="<?= $base_url ?>" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Tentang Kami</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm mb-5" data-aos="fade-up">
                
                <div class="bg-dark text-white text-center py-5 rounded-top" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                    <i class="bi bi-building" style="font-size: 4rem; opacity: 0.8;"></i>
                    <h2 class="fw-bold mt-2">SIGER INFO MEDIA</h2>
                    <p class="mb-0 opacity-75">Portal Berita Terpercaya & Aktual</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">Siapa Kami?</h4>
                    <p class="text-secondary lh-lg mb-5">
                        <strong class="text-primary">Siger Info Media</strong> adalah portal berita daring yang lahir dari semangat untuk menyajikan informasi yang akurat, berimbang, dan mencerdaskan. Berbasis di Lampung, kami berkomitmen mengangkat potensi daerah sekaligus menyajikan isu nasional dan internasional yang relevan bagi masyarakat luas.
                        <br><br>
                        Kami percaya bahwa di era digital yang serba cepat, akurasi data dan kedalaman informasi tetap menjadi kunci. Oleh karena itu, Siger Info Media hadir tidak hanya sebagai penyampai kabar, tetapi juga sebagai referensi terpercaya bagi pembaca dalam mengambil keputusan.
                    </p>

                    <div class="row mb-5">
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-4 rounded h-100 border-start border-4 border-primary">
                                <h5 class="fw-bold mb-3"><i class="bi bi-eye text-primary"></i> Visi</h5>
                                <p class="small text-muted mb-0">
                                    Menjadi media online rujukan utama yang inspiratif, edukatif, dan berkontribusi dalam pembangunan masyarakat cerdas di era digital.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-4 rounded h-100 border-start border-4 border-success">
                                <h5 class="fw-bold mb-3"><i class="bi bi-bullseye text-success"></i> Misi</h5>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li>Menyajikan berita secara cepat, tepat, dan akurat.</li>
                                    <li>Menjunjung tinggi kode etik jurnalistik.</li>
                                    <li>Mengangkat potensi lokal ke kancah nasional.</li>
                                    <li>Memberikan edukasi melalui konten informatif.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">Susunan Redaksi</h4>
                    <div class="table-responsive mb-5">
                        <table class="table table-striped table-hover align-middle">
                            <tbody>
                                <tr>
                                    <td width="40%" class="fw-bold text-secondary">Pimpinan Umum</td>
                                    <td>Udin 1</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Pemimpin Redaksi</td>
                                    <td>Udin 2</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Redaktur Pelaksana</td>
                                    <td>Udin 3</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">IT & Development</td>
                                    <td>Udin 4</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Reporter</td>
                                    <td>
                                        Udin 5
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">Hubungi Kami</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 fw-bold text-dark">Alamat Kantor:</p>
                            <p class="text-secondary small">
                                Jl. Raden Intan No. 123, Tanjung Karang Pusat,<br>
                                Bandar Lampung, Lampung, 35111
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 fw-bold text-dark">Kontak Digital:</p>
                            <ul class="list-unstyled text-secondary small">
                                <li class="mb-1"><i class="bi bi-envelope me-2"></i> redaksi@sigerinfo.com</li>
                                <li class="mb-1"><i class="bi bi-whatsapp me-2"></i> +62 812-3456-7890</li>
                                <li class="mb-1"><i class="bi bi-globe me-2"></i> www.sigerinfo.com</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">
            <?php include 'includes/sidebar.php'; ?>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>