<?php 
require '../../config/database.php';
require '../../config/helpers.php';
$notif = null;
if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if ($fullname && $username && strlen($password) >= 8) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, fullname) VALUES ('$username', '$hashed_password', '$fullname')";
        if (mysqli_query($conn, $query)) {
            $notif = ['success', 'Akun Admin Berhasil Dibuat! Silakan login.'];
        } else {
            $notif = ['danger', 'Gagal: ' . mysqli_error($conn)];
        }
    } else {
        $notif = ['warning', 'Data tidak lengkap atau password kurang dari 8 karakter!'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin | URBANLOKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= assetUrl('css/modern.css') ?>">
    <style>
        html, body { height: 100%; }
    </style>
</head>
<body class="auth-container">
    <div class="auth-card fade-in">
        <div style="text-align: center; margin-bottom: 2rem;">
            <i class="fa-solid fa-cubes" style="font-size: 3rem; background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 1rem; display: block;"></i>
            <h2 style="margin-bottom: 0.5rem; font-size: 1.75rem;">URBANLOKA</h2>
            <p class="auth-subtitle">Daftar Akun Administrator</p>
        </div>
        <?php if ($notif): ?>
            <div class="alert alert-<?= $notif[0] ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($notif[1]) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="" method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Nama Lengkap</label>
                <input type="text" name="fullname" class="form-control" placeholder="Masukkan nama lengkap" required minlength="3">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fa-solid fa-at me-2 text-primary"></i>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Pilih username" required pattern="[A-Za-z0-9_]+">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold"><i class="fa-solid fa-lock me-2 text-primary"></i>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required minlength="8">
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100 py-3 fw-bold mt-4"><i class="fa-solid fa-check me-2"></i>Buat Akun</button>
            <p class="text-center small mt-3 mb-0">
                Sudah punya akun? <a href="login.php" class="fw-bold text-primary">Login di sini</a>
            </p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
