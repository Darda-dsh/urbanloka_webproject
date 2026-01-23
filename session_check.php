<?php
/**
 * Proteksi Halaman - Cek apakah user sudah login
 */

// Panggil database dan helper jika belum ada
require_once _DIR_ . '/database.php';
require_once _DIR_ . '/helpers.php';

// 1. Cek Login Umum
if (!isset($_SESSION['user_id'])) {
    header("Location: " . url('login.php?msg=login_first'));
    exit();
}

/**
 * FUNGSI PROTEKSI ADMIN
 */
if (!function_exists('restrictToAdmin')) {
    function restrictToAdmin() {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: " . url('modules/terminal/index.php?msg=unauthorized'));
            exit();
        }
    }
}

/**
 * FUNGSI PROTEKSI KASIR
 */
if (!function_exists('restrictToKasir')) {
    function restrictToKasir() {
        if ($_SESSION['role'] !== 'kasir') {
            header("Location: " . url('modules/analytics/dashboard.php?msg=admin_only'));
            exit();
        }
    }
}
?>