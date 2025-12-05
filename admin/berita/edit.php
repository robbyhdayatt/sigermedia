<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 

$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'"));
?>

<style>
    .ck-editor__editable_inline { min-height: 500px; }
</style>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5>Edit Berita</h5></div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="fw-bold">Judul</label>
                <input type="text" name="judul" class="form-control form-control-lg" value="<?= $data['judul'] ?>" required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <?php 
                        $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_array($kat)){
                            $sel = ($k['id'] == $data['id_kategori']) ? 'selected' : '';
                            echo "<option value='$k[id]' $sel>$k[nama_kategori]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Tag</label>
                    <input type="text" name="tag" class="form-control" value="<?= isset($data['tag']) ? $data['tag'] : '' ?>" placeholder="Pisahkan dengan koma">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Ganti Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Isi Berita</label>
                <textarea name="isi_berita" id="editor"><?= $data['isi_berita'] ?></textarea>
            </div>
            
            <button type="submit" name="update" class="btn btn-primary px-4">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary px-4">Batal</a>
        </form>

        <?php
        if(isset($_POST['update'])){
            $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $slug  = strtolower(str_replace(' ', '-', $judul));
            $isi   = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
            $tag   = mysqli_real_escape_string($koneksi, $_POST['tag']);
            $kategori = $_POST['id_kategori'];
            
            $foto = $_FILES['gambar']['name'];
            
            if($foto != ""){
                $tmp = $_FILES['gambar']['tmp_name'];
                $ext = pathinfo($foto, PATHINFO_EXTENSION);
                $nama_baru = rand(1000,9999).'_'.uniqid().'.'.$ext;
                
                if(file_exists('../../uploads/'.$data['gambar']) && $data['gambar'] != '') unlink('../../uploads/'.$data['gambar']);
                move_uploaded_file($tmp, '../../uploads/'.$nama_baru);
                
                // Update dengan gambar & tag
                $query = "UPDATE berita SET judul='$judul', slug_berita='$slug', isi_berita='$isi', id_kategori='$kategori', tag='$tag', gambar='$nama_baru' WHERE id='$id'";
            } else {
                // Update tanpa ganti gambar, tapi update tag
                $query = "UPDATE berita SET judul='$judul', slug_berita='$slug', isi_berita='$isi', id_kategori='$kategori', tag='$tag' WHERE id='$id'";
            }
            
            if(mysqli_query($koneksi, $query)) echo "<script>alert('Update Berhasil!'); window.location='index.php';</script>";
        }
        ?>
    </div>
</div>
<?php include '../template/footer.php'; ?>