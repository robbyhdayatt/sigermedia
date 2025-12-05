<?php 
include '../../config/koneksi.php'; 
include '../template/header.php'; 
?>

<div class="card border-0 shadow-sm col-md-8">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pasang Iklan Baru</h6>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Judul / Nama Klien</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Link Tujuan (URL)</label>
                <input type="url" name="link" class="form-control" placeholder="https://..." required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">File Banner</label>
                <input type="file" name="gambar" id="imgInput" class="form-control" accept="image/*" required onchange="previewImage(this)">
                <small class="text-muted d-block mt-1">Disarankan ukuran persegi (300x300) atau (300x250).</small>
                
                <div class="mt-3">
                    <img id="imgPreview" src="#" alt="Preview Gambar" class="img-fluid rounded border d-none" style="max-height: 200px;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif (Langsung Tayang)</option>
                    <option value="nonaktif">Nonaktif (Simpan Saja)</option>
                </select>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan Iklan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>

        <?php
        if(isset($_POST['simpan'])){
            $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
            $link = mysqli_real_escape_string($koneksi, $_POST['link']);
            $status = $_POST['status'];
            
            // Buat folder manual jika belum ada
            $folder_path = '../../uploads/iklan';
            if(!is_dir($folder_path)){ mkdir($folder_path, 0777, true); }

            $foto = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];
            // Tambahkan angka acak agar nama file tidak bentrok
            $nama_baru = rand(100,999).'_'.str_replace(' ', '-', $foto);
            
            // Cek apakah upload berhasil
            if(move_uploaded_file($tmp, $folder_path.'/'.$nama_baru)){
                $simpan = mysqli_query($koneksi, "INSERT INTO iklan (judul, link, gambar, status) VALUES ('$judul', '$link', '$nama_baru', '$status')");
                if($simpan) echo "<script>window.location='index.php';</script>";
            } else {
                echo "<script>alert('Gagal upload gambar! Pastikan folder uploads/iklan tersedia.');</script>";
            }
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
            preview.classList.remove('d-none'); // Tampilkan gambar
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include '../template/footer.php'; ?>