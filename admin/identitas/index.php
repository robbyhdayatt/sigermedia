<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 

// Ambil Data Identitas (ID = 1)
$query = mysqli_query($koneksi, "SELECT * FROM identitas WHERE id=1");
$d = mysqli_fetch_assoc($query);

// LOGIKA UPDATE
if(isset($_POST['update'])){
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email  = mysqli_real_escape_string($koneksi, $_POST['email']);
    $hp     = mysqli_real_escape_string($koneksi, $_POST['hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $fb     = mysqli_real_escape_string($koneksi, $_POST['fb']);
    $ig     = mysqli_real_escape_string($koneksi, $_POST['ig']);
    $desc   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Cek Ganti Logo
    $foto = $_FILES['logo']['name'];
    if($foto != ""){
        $tmp = $_FILES['logo']['tmp_name'];
        $logo_baru = rand(1,999).'_'.$foto;
        // Upload
        move_uploaded_file($tmp, '../../assets/images/'.$logo_baru);
        // Update DB dengan Logo
        mysqli_query($koneksi, "UPDATE identitas SET nama_website='$nama', email='$email', no_hp='$hp', alamat='$alamat', facebook='$fb', instagram='$ig', deskripsi='$desc', logo='$logo_baru' WHERE id=1");
    } else {
        // Update DB tanpa Logo
        mysqli_query($koneksi, "UPDATE identitas SET nama_website='$nama', email='$email', no_hp='$hp', alamat='$alamat', facebook='$fb', instagram='$ig', deskripsi='$desc' WHERE id=1");
    }

    echo "<script>alert('Data Website Berhasil Diupdate!'); window.location='index.php';</script>";
}
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="m-0 font-weight-bold text-primary"><i class="bi bi-gear-fill me-2"></i>Pengaturan Website</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Website</label>
                        <input type="text" name="nama" class="form-control" value="<?= $d['nama_website'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Redaksi</label>
                        <input type="email" name="email" class="form-control" value="<?= $d['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. Handphone / WhatsApp</label>
                        <input type="text" name="hp" class="form-control" value="<?= $d['no_hp'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Kantor</label>
                        <textarea name="alamat" class="form-control" rows="3"><?= $d['alamat'] ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Link Facebook</label>
                        <input type="text" name="fb" class="form-control" value="<?= $d['facebook'] ?>" placeholder="https://facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Link Instagram</label>
                        <input type="text" name="ig" class="form-control" value="<?= $d['instagram'] ?>" placeholder="https://instagram.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Meta (SEO)</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $d['deskripsi'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo Website</label><br>
                        <img src="../../assets/images/<?= $d['logo'] ?>" class="img-thumbnail mb-2" width="150">
                        <input type="file" name="logo" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti logo.</small>
                    </div>
                </div>
            </div>
            
            <hr>
            <button type="submit" name="update" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>