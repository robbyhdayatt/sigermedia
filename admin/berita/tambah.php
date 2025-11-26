<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5>Tambah Berita Baru</h5></div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul Berita</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php 
                        $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_array($kat)){ echo "<option value='$k[id]'>$k[nama_kategori]</option>"; }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-2">Isi Berita</label>
                <textarea name="isi_berita" id="editor" class="form-control" rows="10"></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Publish</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
        
        <?php
        if(isset($_POST['simpan'])){
            $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $slug = strtolower(str_replace(' ', '-', $judul));
            $isi = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
            $kategori = $_POST['id_kategori'];
            $user_id = $_SESSION['user_id'];

            $foto = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];
            $nama_baru = rand(1,999).'_'.$foto;
            
            // Upload ke folder uploads (naik 2 tingkat)
            move_uploaded_file($tmp, '../../uploads/'.$nama_baru);

            $insert = mysqli_query($koneksi, "INSERT INTO berita (judul, slug_berita, isi_berita, gambar, id_kategori, id_user) VALUES ('$judul', '$slug', '$isi', '$nama_baru', '$kategori', '$user_id')");
            
            if($insert) echo "<script>window.location='index.php';</script>";
        }
        ?>
    </div>
</div>

<?php include '../template/footer.php'; ?>