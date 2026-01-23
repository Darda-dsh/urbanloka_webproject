<?php
// Pengaturan Database
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan untuk XAMPP/Laragon standar
$db   = "urbanloka_db";

// Koneksi ke MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Memulai Session secara aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>