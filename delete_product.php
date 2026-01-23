<?php
require '../../config/database.php';
require '../../session_check.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil nama file gambar agar bisa dihapus dari folder uploads
    $res = mysqli_query($conn, "SELECT image FROM products WHERE id = $id");
    $p = mysqli_fetch_assoc($res);
    
    if ($p['image'] != "" && file_exists("../../uploads/products/" . $p['image'])) {
        unlink("../../uploads/products/" . $p['image']); // Hapus file fisik
    }
    
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
}
header("Location: index.php?msg=deleted");