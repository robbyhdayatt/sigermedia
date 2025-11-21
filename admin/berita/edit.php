<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'"));
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><h5>Edit Berita</h5></div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <?php 
                        $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_array($kat)){
                            $sel = ($k['id'] == $data['id_kategori']) ? 'selected' : '';
                            echo "<option value='$k[id]' $sel>$k[nama_kategori]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" class="form-control">
                    <img src="<?= $base_url ?>uploads/<?= $data['gambar'] ?>" width="80" class="mt-2">
                </div>
            </div>
            <div class="mb-3">
                <label>Isi Berita</label>
                <textarea name="isi_berita" class="form-control" rows="5"><?= $data['isi_berita'] ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>

        <?php
        if(isset($_POST['update'])){
            $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $slug = strtolower(str_replace(' ', '-', $judul));
            $isi = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);
            $kategori = $_POST['id_kategori'];
            
            $foto = $_FILES['gambar']['name'];
            
            if($foto != ""){
                // Jika ganti gambar
                $tmp = $_FILES['gambar']['tmp_name'];
                $nama_baru = rand(1,999).'_'.$foto;
                
                // Hapus gambar lama
                if(file_exists('../../uploads/'.$data['gambar'])) unlink('../../uploads/'.$data['gambar']);
                
                move_uploaded_file($tmp, '../../uploads/'.$nama_baru);
                
                $query = "UPDATE berita SET judul='$judul', slug_berita='$slug', isi_berita='$isi', id_kategori='$kategori', gambar='$nama_baru' WHERE id='$id'";
            } else {
                // Jika tidak ganti gambar
                $query = "UPDATE berita SET judul='$judul', slug_berita='$slug', isi_berita='$isi', id_kategori='$kategori' WHERE id='$id'";
            }
            
            $run = mysqli_query($koneksi, $query);
            if($run) echo "<script>window.location='index.php';</script>";
        }
        ?>
    </div>
</div>

<?php include '../template/footer.php'; ?>