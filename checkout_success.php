<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

if (!isset($_GET['order_id'])) {
    header("Location: history.php");
    exit;
}

$order_id = $_GET['order_id'];
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id"));

if (!$order) {
    header("Location: history.php");
    exit;
}

$details = mysqli_query($conn, "SELECT od.*, p.name FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = $order_id");

include '../../partials/header.php';
include '../../partials/sidebar.php';

// Safe data access
$total_before = isset($order['total_before_discount']) ? (int)$order['total_before_discount'] : 0;
$discount = isset($order['discount_amount']) ? (int)$order['discount_amount'] : 0;
$final_total = isset($order['final_total']) ? (int)$order['final_total'] : 0;
?>
<div style="max-width: 600px; margin: 0 auto; padding: 2rem 0;">
  <div class="card">
    <div class="card-body" style="text-align: center; padding: 2rem;">
      <div style="margin-bottom: 2rem;">
        <i class="fa-solid fa-circle-check fa-5x" style="color: #10b981; margin-bottom: 1rem;"></i>
        <h2 style="font-weight: 700; color: #10b981; margin-bottom: 0.5rem;">Order Berhasil!</h2>
        <p style="color: #64748b; margin-bottom: 0.25rem;">Order telah diproses dan tersimpan di sistem</p>
        <p style="color: #94a3b8; font-size: 0.9rem;">ID Order: <strong>#<?= $order_id ?></strong></p>
      </div>

      <div style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 1.5rem 0; margin: 2rem 0; text-align: left;">
        <h6 style="font-weight: 700; margin-bottom: 1rem; color: #1e293b;">Ringkasan Pesanan</h6>
        <div style="overflow-x: auto;">
          <table style="width: 100%; font-size: 0.9rem;">
            <thead style="background: #f1f5f9; border-radius: 0.5rem;">
              <tr>
                <th style="padding: 0.75rem; text-align: left; color: #64748b; font-weight: 600;">Produk</th>
                <th style="padding: 0.75rem; text-align: center; color: #64748b; font-weight: 600;">Qty</th>
                <th style="padding: 0.75rem; text-align: right; color: #64748b; font-weight: 600;">Harga</th>
              </tr>
            </thead>
            <tbody>
              <?php while($d = mysqli_fetch_assoc($details)): 
                $qty = isset($d['qty']) ? (int)$d['qty'] : 0;
                $subtotal = isset($d['subtotal']) ? (int)$d['subtotal'] : 0;
              ?>
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 0.75rem; color: #1e293b;"><?= htmlspecialchars($d['name']) ?></td>
                <td style="padding: 0.75rem; text-align: center; color: #64748b;"><?= $qty ?></td>
                <td style="padding: 0.75rem; text-align: right; color: #6366f1; font-weight: 600;">RP <?= number_format($subtotal, 0, ',', '.') ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <div style="margin-top: 1.5rem;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div>
              <small style="color: #94a3b8; display: block; margin-bottom: 0.25rem;">Subtotal</small>
              <p style="font-weight: 700; color: #1e293b; margin: 0;">RP <?= number_format($total_before, 0, ',', '.') ?></p>
            </div>
            <div>
              <small style="color: #94a3b8; display: block; margin-bottom: 0.25rem;">Diskon</small>
              <p style="font-weight: 700; color: #ef4444; margin: 0;">-RP <?= number_format($discount, 0, ',', '.') ?></p>
            </div>
          </div>
          <div style="border-top: 2px solid #e2e8f0; padding-top: 1rem;">
            <small style="color: #94a3b8; display: block; margin-bottom: 0.25rem;">Total Akhir</small>
            <h4 style="font-weight: 700; color: #6366f1; margin: 0; font-size: 1.5rem;">RP <?= number_format($final_total, 0, ',', '.') ?></h4>
          </div>
        </div>
      </div>

      <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
        <a href="index.php" class="btn btn-primary" style="padding: 0.875rem 1.5rem; text-decoration: none;">
          <i class="fa-solid fa-plus me-2"></i>Transaksi Baru
        </a>
        <a href="history.php" class="btn btn-outline-primary" style="padding: 0.875rem 1.5rem; text-decoration: none;">
          <i class="fa-solid fa-history me-2"></i>Lihat Riwayat
        </a>
      </div>
    </div>
  </div>
</div>
<?php include '../../partials/footer.php'; ?>

