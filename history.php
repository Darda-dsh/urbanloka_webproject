<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

include '../../partials/header.php';
// sidebar.php sudah include otomatis di header baru kita
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem; letter-spacing: -1px;">Order History</h1>
        <p style="color: #64748b; font-size: 1rem; margin: 0;">Lihat riwayat semua transaksi penjualan Urbanloka.</p>
    </div>
    <button onclick="window.print()" class="btn btn-outline-dark fw-bold" style="border-radius: 12px; padding: 10px 20px;">
        <i class="fa-solid fa-print me-2"></i>Cetak Laporan
    </button>
</div>

<div class="card-custom p-0 overflow-hidden shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Tanggal & Waktu</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Pelanggan</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Produk Terjual</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-end">Diskon</th>
                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Total Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Menggunakan created_at sesuai skema database kita
                $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
                if (mysqli_num_rows($orders) > 0):
                    while($o = mysqli_fetch_assoc($orders)): 
                        $order_id = $o['id'];
                        
                        // Ambil detail item untuk setiap order
                        $details = mysqli_query($conn, "SELECT p.name, od.qty FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = $order_id");
                        $items = [];
                        while($d = mysqli_fetch_assoc($details)) { 
                            $items[] = htmlspecialchars($d['name']) . " (" . $d['qty'] . ")"; 
                        }
                        
                        $order_date = isset($o['created_at']) ? date('d M Y, H:i', strtotime($o['created_at'])) : '-';
                        $customer = htmlspecialchars($o['customer_name'] ?? 'Walk-in Customer');
                        $discount = (int)($o['discount'] ?? 0);
                        $final_total = (int)($o['final_total'] ?? 0);
                ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td class="ps-4 small fw-medium text-secondary"><?= $order_date ?></td>
                    <td>
                        <div class="fw-bold text-dark"><?= $customer ?></div>
                        <small class="text-muted">ID: #ORD-0<?= $order_id ?></small>
                    </td>
                    <td>
                        <div class="small text-muted text-truncate" style="max-width: 300px;">
                            <?= implode(', ', $items) ?: '<i class="text-muted small">No items</i>' ?>
                        </div>
                    </td>
                    <td class="text-end text-danger fw-medium">
                        <?= $discount > 0 ? '-RP ' . number_format($discount, 0, ',', '.') : '-' ?>
                    </td>
                    <td class="pe-4 text-end">
                        <span class="fw-bold" style="color: #0f172a; font-size: 1.05rem;">
                            RP <?= number_format($final_total, 0, ',', '.') ?>
                        </span>
                    </td>
                </tr>
                <?php 
                    endwhile; 
                else: 
                ?>
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-receipt fa-3x mb-3" style="opacity: 0.2;"></i>
                            <p>Belum ada riwayat transaksi.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>