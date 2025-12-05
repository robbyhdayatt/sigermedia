<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<style>
    .ck-editor__editable_inline { min-height: 500px; }
</style>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="fw-bold mb-0">Tambah Berita Baru</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="fw-bold mb-2">Judul Berita</label>
                <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan judul berita..." required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="fw-bold mb-2">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php 
                        $kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                        while($k = mysqli_fetch_array($kat)){ 
                            echo "<option value='$k[id]'>$k[nama_kategori]</option>"; 
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold mb-2">Tag / Kata Kunci</label>
                    <input type="text" name="tag" class="form-control" placeholder="Contoh: ekonomi, lampung, viral">
                    <small class="text-muted">Pisahkan dengan koma (,)</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold mb-2">Gambar Sampul</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="fw-bold mb-2">Isi Berita</label>
                <textarea name="isi_berita" id="editor" class="form-control"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="simpan" class="btn btn-primary px-4"><i class="bi bi-send"></i> Publish</button>
                <a href="index.php" class="btn btn-secondary px-4">Batal</a>
            </div>
        </form>
        
        <?php
        if(isset($_POST['simpan'])){
            $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $slug     = strtolower(str_replace(' ', '-', $judul));
            $isi      = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
            // Amankan input tag
            $tag      = mysqli_real_escape_string($koneksi, $_POST['tag']);
            $kategori = $_POST['id_kategori'];
            $user_id  = $_SESSION['user_id'];

            $foto = $_FILES['gambar']['name'];
            $tmp  = $_FILES['gambar']['tmp_name'];
            $ext  = pathinfo($foto, PATHINFO_EXTENSION);
            
            // Validasi & Upload
            if(in_array($ext, ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])){
                $nama_baru = rand(1000,9999) . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($tmp, '../../uploads/'.$nama_baru);

                // Insert data termasuk kolom TAG
                $insert = mysqli_query($koneksi, "INSERT INTO berita (judul, slug_berita, isi_berita, gambar, id_kategori, id_user, tag) VALUES ('$judul', '$slug', '$isi', '$nama_baru', '$kategori', '$user_id', '$tag')");
                
                if($insert) echo "<script>alert('Berita berhasil dipublish!'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Format gambar harus JPG/PNG');</script>";
            }
        }
        ?>
    </div>
</div>
<?php include '../template/footer.php'; ?>