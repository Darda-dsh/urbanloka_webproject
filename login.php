<?php 
// Memanggil config menggunakan Absolute Path agar tidak error No Such File
require_once _DIR_ . '/config/database.php';
require_once _DIR_ . '/config/helpers.php';

// Jika sudah login, langsung lempar ke dashboard/terminal
if (isset($_SESSION['user_id'])) {
    $target = ($_SESSION['role'] === 'admin') ? 'modules/analytics/dashboard.php' : 'modules/terminal/index.php';
    header("Location: " . url($target));
    exit();
}

$notif = null;
if (isset($_GET['msg'])) {
    $messages = [
        'wrong_password' => ['danger', 'Password salah!'],
        'user_not_found' => ['danger', 'Username tidak ditemukan!'],
        'logout'         => ['success', 'Anda telah logout.'],
        'login_first'    => ['warning', 'Silakan login terlebih dahulu.']
    ];
    if (isset($messages[$_GET['msg']])) {
        $notif = $messages[$_GET['msg']];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | URBANLOKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #0f172a; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; color: #f8fafc; }
        .auth-card { background: #1e293b; padding: 2.5rem; border-radius: 1.5rem; width: 100%; max-width: 400px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border: 1px solid #334155; }
        .form-control { background: #0f172a; border: 1px solid #334155; color: white; padding: 0.75rem; }
        .form-control:focus { background: #0f172a; color: white; border-color: #D4AF37; box-shadow: none; }
        .btn-primary { background: #D4AF37; border: none; color: #000; font-weight: bold; }
        .btn-primary:hover { background: #b8962e; color: #000; }
        .brand-icon { color: #D4AF37; font-size: 3rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <i class="fa-solid fa-crown brand-icon"></i>
            <h2 class="fw-bold">URBANLOKA</h2>
            <p class="text-muted small text-uppercase tracking-widest">Street-Industrial System</p>
        </div>

        <?php if ($notif): ?>
            <div class="alert alert-<?= $notif[0] ?> alert-dismissible fade show small" role="alert" style="background: rgba(0,0,0,0.2); color: white; border: 1px solid #334155;">
                <?= htmlspecialchars($notif[1]) ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="process.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">USERNAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-secondary" style="border-color: #334155;"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="username" class="form-control border-start-0" placeholder="Username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-secondary" style="border-color: #334155;"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2">
                AUTHENTICATE <i class="fa-solid fa-right-to-bracket ms-2"></i>
            </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>