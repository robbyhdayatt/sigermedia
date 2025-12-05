<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM iklan WHERE id='$id'"));
?>

<div class="card border-0 shadow-sm col-md-8">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Iklan</h6>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Judul</label>
                <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Link Tujuan</label>
                <input type="url" name="link" class="form-control" value="<?= $data['link'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Ganti Banner</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this)">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted mb-1">Preview:</label><br>
                        <img id="imgPreview" src="../../uploads/iklan/<?= $data['gambar'] ?>" class="img-fluid rounded border" style="max-height: 120px;">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" <?= ($data['status']=='aktif')?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= ($data['status']=='nonaktif')?'selected':'' ?>>Nonaktif</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>

        <?php
        if(isset($_POST['update'])){
            $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $link = mysqli_real_escape_string($koneksi, $_POST['link']);
            $status = $_POST['status'];
            
            $foto = $_FILES['gambar']['name'];
            if($foto != ""){
                $tmp = $_FILES['gambar']['tmp_name'];
                $nama_baru = rand(100,999).'_'.str_replace(' ', '-', $foto);
                
                // Hapus lama
                if(file_exists('../../uploads/iklan/'.$data['gambar'])) unlink('../../uploads/iklan/'.$data['gambar']);
                move_uploaded_file($tmp, '../../uploads/iklan/'.$nama_baru);
                
                mysqli_query($koneksi, "UPDATE iklan SET judul='$judul', link='$link', status='$status', gambar='$nama_baru' WHERE id='$id'");
            } else {
                mysqli_query($koneksi, "UPDATE iklan SET judul='$judul', link='$link', status='$status' WHERE id='$id'");
            }
            echo "<script>window.location='index.php';</script>";
        }
        ?>
    </div>
</div>

<script>
function previewImage(input) {
    var preview = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../template/footer.php'; ?>