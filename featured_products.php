<?php 
require '../config/database.php';
require '../config/helpers.php';
require '../session_check.php';

$notif = null;

// Handle toggle featured
if (isset($_POST['toggle_featured'])) {
    $product_id = intval($_POST['product_id']);
    $current_status = intval($_POST['current_status']);
    $new_status = $current_status == 1 ? 0 : 1;
    
    $query = "UPDATE products SET is_featured = $new_status WHERE id = $product_id";
    if (mysqli_query($conn, $query)) {
        $notif = ['success', $new_status == 1 ? 'Produk ditandai sebagai unggulan!' : 'Produk dihapus dari unggulan!'];
    } else {
        $notif = ['danger', 'Gagal mengubah status produk'];
    }
}

// Ambil semua produk dengan status featured
$products = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.is_featured DESC, p.id DESC");

// Hitung featured products
$featured_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM products WHERE is_featured = 1"));

include '../partials/header.php';
include '../partials/sidebar.php';
?>

<h1 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Kelola Produk Unggulan</h1>
<p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">Tandai produk mana yang ingin ditampilkan di halaman website</p>

<?php if ($notif): ?>
    <div class="alert alert-<?= $notif[0] ?> alert-dismissible fade show" role="alert" style="margin-bottom: 2rem;">
        <i class="fa-solid fa-<?= $notif[0] === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
        <?= htmlspecialchars($notif[1]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card">
        <div class="card-body">
            <div style="font-size: 2rem; font-weight: 700; color: #6366f1;">
                <?= $featured_count['cnt'] ?>
            </div>
            <p style="color: #64748b; margin: 0;">Produk Unggulan</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="font-size: 2rem; font-weight: 700; color: #10b981;">
                <i class="fa-solid fa-star"></i>
            </div>
            <p style="color: #64748b; margin: 0;">Maksimal 6 produk untuk website</p>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header" style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); border: none; padding: 1.5rem;">
        <h5 style="color: white; margin: 0; font-weight: 700;">
            <i class="fa-solid fa-list me-2"></i>Daftar Produk
        </h5>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 1rem; text-align: left; color: #1e293b; font-weight: 700;">Produk</th>
                        <th style="padding: 1rem; text-align: left; color: #1e293b; font-weight: 700;">Kategori</th>
                        <th style="padding: 1rem; text-align: center; color: #1e293b; font-weight: 700;">Harga</th>
                        <th style="padding: 1rem; text-align: center; color: #1e293b; font-weight: 700;">Stok</th>
                        <th style="padding: 1rem; text-align: center; color: #1e293b; font-weight: 700;">Status</th>
                        <th style="padding: 1rem; text-align: center; color: #1e293b; font-weight: 700;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_assoc($products)): 
                        $is_featured = $product['is_featured'] == 1;
                        $stock = isset($product['stock']) ? (int)$product['stock'] : 0;
                        $price = isset($product['price']) ? (int)$product['price'] : 0;
                    ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 1rem; color: #1e293b; font-weight: 600;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <img src="<?= uploadUrl('products/' . $product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem;">
                                <span><?= htmlspecialchars($product['name']) ?></span>
                            </div>
                        </td>
                        <td style="padding: 1rem; color: #64748b;">
                            <span style="background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.9rem;">
                                <?= htmlspecialchars($product['category_name'] ?? 'Lainnya') ?>
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center; color: #6366f1; font-weight: 600;">
                            Rp <?= number_format($price, 0, ',', '.') ?>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <?php if ($stock > 20): ?>
                                <span style="background: #dcfce7; color: #166534; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                                    ✅ <?= $stock ?> pcs
                                </span>
                            <?php elseif ($stock > 0): ?>
                                <span style="background: #fef08a; color: #854d0e; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                                    ⚠️ <?= $stock ?> pcs
                                </span>
                            <?php else: ?>
                                <span style="background: #fee2e2; color: #991b1b; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                                    ❌ Habis
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <?php if ($is_featured): ?>
                                <span style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fa-solid fa-star me-1"></i>Unggulan
                                </span>
                            <?php else: ?>
                                <span style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fa-solid fa-circle me-1"></i>Biasa
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="current_status" value="<?= $product['is_featured'] ?>">
                                <button type="submit" name="toggle_featured" class="btn" style="background: <?= $is_featured ? '#ef4444' : '#6366f1' ?>; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                    <i class="fa-solid fa-<?= $is_featured ? 'times' : 'star' ?> me-1"></i><?= $is_featured ? 'Hapus' : 'Jadikan' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Info Box -->
<div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 1.5rem; border-radius: 0.5rem; margin-top: 2rem;">
    <p style="color: #047857; margin: 0;">
        <i class="fa-solid fa-info-circle me-2"></i>
        <strong>Info:</strong> Produk yang ditandai sebagai "Unggulan" akan ditampilkan di halaman website publik. Maksimal 6 produk untuk tampilan optimal.
    </p>
</div>

<?php include '../partials/footer.php'; ?>
