<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

restrictToAdmin();

include '../../partials/header.php';
// sidebar.php sudah dipanggil otomatis di dalam header.php sesuai kode sebelumnya

// Data statistik
$revenue      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(final_total) as total FROM orders"));
$stock        = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stock) as total FROM products"));
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"));
$products_cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"));

$total_revenue = (int)($revenue['total'] ?? 0);
$total_stock   = (int)($stock['total'] ?? 0);
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom">
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0;">Dashboard</h1>
            <p style="color: #64748b; margin: 0;">Halo, <b><?= htmlspecialchars($_SESSION['fullname']) ?></b>. Pantau statistik Urbanloka di sini.</p>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card-custom text-center">
            <div class="stat-icon bg-light text-primary mx-auto mb-3">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
            <small class="text-muted fw-bold text-uppercase">Revenue</small>
            <h4 class="fw-bold mt-2">RP <?= number_format($total_revenue, 0, ',', '.') ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom text-center">
            <div class="stat-icon bg-light text-success mx-auto mb-3">
                <i class="fa-solid fa-boxes-packing"></i>
            </div>
            <small class="text-muted fw-bold text-uppercase">Total Stock</small>
            <h4 class="fw-bold mt-2"><?= number_format($total_stock, 0, ',', '.') ?> <small>PCS</small></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom text-center">
            <div class="stat-icon bg-light text-danger mx-auto mb-3">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <small class="text-muted fw-bold text-uppercase">Orders</small>
            <h4 class="fw-bold mt-2"><?= $total_orders['total'] ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom text-center">
            <div class="stat-icon bg-light text-warning mx-auto mb-3">
                <i class="fa-solid fa-tags"></i>
            </div>
            <small class="text-muted fw-bold text-uppercase">Catalog</small>
            <h4 class="fw-bold mt-2"><?= $products_cnt['total'] ?> <small>Items</small></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card-custom">
            <h6 class="fw-bold mb-4"><i class="fa fa-fire text-danger me-2"></i>5 Produk Terlaris</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="small text-muted"><th>PRODUK</th><th class="text-end">TERJUAL</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $top = mysqli_query($conn, "SELECT p.name, SUM(od.qty) as sold FROM order_details od JOIN products p ON od.product_id = p.id GROUP BY od.product_id ORDER BY sold DESC LIMIT 5");
                        while($row = mysqli_fetch_assoc($top)): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="text-end"><span class="badge bg-soft-primary" style="background:#eef2ff; color:#6366f1;"><?= $row['sold'] ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card-custom">
            <h6 class="fw-bold mb-4"><i class="fa fa-exclamation-triangle text-warning me-2"></i>Stok Hampir Habis</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="small text-muted"><th>PRODUK</th><th class="text-end">SISA</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $low = mysqli_query($conn, "SELECT name, stock FROM products WHERE stock < 20 ORDER BY stock ASC LIMIT 5");
                        while($row = mysqli_fetch_assoc($low)): ?>
                        <tr>
                            <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="text-end"><span class="badge bg-danger" style="padding: 6px 12px;"><?= $row['stock'] ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>