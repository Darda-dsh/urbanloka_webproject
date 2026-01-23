<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

if (isset($_GET['quick_add'])) {
    $id = (int)$_GET['quick_add'];
    mysqli_query($conn, "UPDATE products SET stock = stock + 12 WHERE id = $id");
    header("Location: index.php");
    exit;
}

include '../../partials/header.php';
?>

<div class="d-flex justify-content-between align-items-end mb-5">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; letter-spacing: -1px;">Warehouse Management</h1>
        <p style="color: #64748b; font-size: 1rem; margin: 0;">Kelola stok produk Anda dengan mudah dan efisien.</p>
    </div>
    <a href="add_product.php" class="btn btn-dark" style="background: #000; border: 1px solid #D4AF37; color: #D4AF37; padding: 12px 24px; border-radius: 12px; font-weight: 700;">
        <i class="fa-solid fa-plus me-2"></i>TAMBAH PRODUK
    </a>
</div>

<div class="row g-4">
    <?php 
    $query = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
    while($p = mysqli_fetch_assoc($query)): 
        $stock = (int)($p['stock'] ?? 0);
        $is_limited = ($p['drop_status'] == 'Limited');
    ?>
    <div class="col-md-4 col-lg-3">
        <div class="card-custom h-100 p-0 overflow-hidden shadow-sm border-0" style="transition: 0.3s;">
            <div style="position: relative;">
                <img src="<?= uploadUrl('products/' . $p['image']) ?>" class="w-100" style="height: 220px; object-fit: cover;" alt="<?= htmlspecialchars($p['name']) ?>">
                <?php if($is_limited): ?>
                    <span class="badge" style="position: absolute; top: 15px; right: 15px; background: #D4AF37; color: #000; font-weight: 800; font-size: 0.7rem; letter-spacing: 1px;">LIMITED DROP</span>
                <?php endif; ?>
            </div>
            
            <div class="p-4">
                <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;"><?= htmlspecialchars($p['category_name'] ?? 'Uncategorized') ?></small>
                <h6 class="fw-bold mt-1 mb-3 text-truncate" style="color: #1e293b; font-size: 1.1rem;"><?= htmlspecialchars($p['name']) ?></h6>

                <div style="background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #f1f5f9;">
                    <small class="text-muted d-block text-center mb-1 fw-semibold">Current Stock</small>
                    <div class="text-center" style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">
                        <?= $stock ?> <span style="font-size: 0.9rem; color: #94a3b8; font-weight: 400;">PCS</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="?quick_add=<?= $p['id'] ?>" class="btn btn-outline-dark btn-sm flex-grow-1 fw-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-plus me-1"></i> Restock
                    </a>
                    <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-light btn-sm flex-grow-1 fw-bold" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include '../../partials/footer.php'; ?>