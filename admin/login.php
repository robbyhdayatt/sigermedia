<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Siger Info Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .card-login {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #0d6efd;
            color: white;
            border-radius: 15px 15px 0 0 !important;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="card card-login">
        <div class="card-header">
            <h4 class="mb-0">Siger Media</h4>
            <small>Silakan Login Administrator</small>
        </div>
        <div class="card-body p-4">
            
            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger'>Login Gagal! Username atau Password salah.</div>";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "<div class='alert alert-warning'>Anda harus login untuk mengakses halaman admin.</div>";
                } else if($_GET['pesan'] == "logout"){
                    echo "<div class='alert alert-success'>Anda telah berhasil logout.</div>";
                }
            }
            ?>

            <form action="cek_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Masuk Sekarang</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted py-3">
            &copy; 2024 Siger Info Media
        </div>
    </div>

</body>
</html>