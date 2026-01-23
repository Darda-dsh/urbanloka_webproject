<?php
require '../../config/database.php';

if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Password diacak agar tidak bisa dibaca manusia di database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, fullname) VALUES ('$username', '$hashed_password', '$fullname')";
    
    if (mysqli_query($conn, $query)) {
        echo "Akun Admin Berhasil Dibuat! Silakan login.";
        header("Refresh: 2; url=login.php");
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>