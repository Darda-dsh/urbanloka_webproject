<?php
require '../../config/database.php';

if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = $_POST['password'];

    // Ambil data user
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$u'");
    $user  = mysqli_fetch_assoc($query);

    if ($user) {
        // CEK PASSWORD LANGSUNG (TIDAK PAKAI HASH BIAR TIDAK ERROR LAGI)
        if ($p === $user['password']) {
            
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role']     = $user['role'];

            // REDIRECT BERDASARKAN ROLE
            if ($user['role'] === 'admin') {
                header("Location: ../analytics/dashboard.php");
            } else {
                header("Location: ../terminal/index.php");
            }
            exit();
            
        } else {
            header("Location: login.php?msg=wrong_password");
            exit();
        }
    } else {
        header("Location: login.php?msg=user_not_found");
        exit();
    }
}