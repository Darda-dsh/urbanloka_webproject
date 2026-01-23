<?php
/**
 * Helpers - Kumpulan fungsi helper untuk aplikasi URBANLOKA
 */

if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        
        // Deteksi folder root project secara dinamis agar aman di XAMPP/Laragon
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base = substr($script_name, 0, strpos($script_name, '/modules') ?: strpos($script_name, '/public') ?: strrpos($script_name, '/'));
        
        return $protocol . $host . rtrim($base, '/');
    }
}

if (!function_exists('assetUrl')) {
    function assetUrl($path) {
        return getBaseUrl() . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('moduleUrl')) {
    function moduleUrl($module, $file = 'index.php') {
        return getBaseUrl() . '/modules/' . $module . '/' . $file;
    }
}

if (!function_exists('uploadUrl')) {
    function uploadUrl($path) {
        return getBaseUrl() . '/uploads/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url($path = '') {
        return getBaseUrl() . '/' . ltrim($path, '/');
    }
}

if (!function_exists('getCurrentUser')) {
    function getCurrentUser($conn) {
        if (!isset($_SESSION['user_id'])) return "Guest";
        $uid = $_SESSION['user_id'];
        $query = mysqli_query($conn, "SELECT fullname FROM users WHERE id = $uid");
        $data = mysqli_fetch_assoc($query);
        return $data ? $data['fullname'] : "User";
    }
}

if (!function_exists('calculate_discount')) {
    function calculate_discount($cart, $type = null) {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * ($item['qty'] ?? 1);
        }
        $discount = 0;
        if ($type === 'member') {
            $discount = $subtotal * 0.1; // 10% member discount
        } elseif ($type === 'bundle' && count($cart) >= 2) {
            $discount = 50000; // Bundle discount
        }
        return $discount;
    }
}
?>