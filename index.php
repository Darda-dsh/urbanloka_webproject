<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

include '../../partials/header.php';
?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 0;">POS Terminal</h1>
                <p style="color: #64748b; margin: 0;">Pilih produk untuk memulai transaksi baru.</p>
            </div>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="fa fa-search text-muted"></i></span>
                <input type="text" id="searchProduct" class="form-control border-start-0" placeholder="Cari SKU atau Nama..." style="border-radius: 0 10px 10px 0;">
            </div>
        </div>

        <div class="row g-3" id="productGrid">
            <?php 
            $query = mysqli_query($conn, "SELECT * FROM products WHERE stock > 0 ORDER BY name ASC");
            while($p = mysqli_fetch_assoc($query)): 
            ?>
            <div class="col-md-4 col-sm-6 product-item">
                <div class="card-custom p-0 overflow-hidden shadow-sm border-0 h-100 btn-add-cart" 
                     data-id="<?= $p['id'] ?>" 
                     data-name="<?= htmlspecialchars($p['name']) ?>" 
                     data-price="<?= $p['price'] ?>"
                     style="cursor: pointer; transition: 0.2s;">
                    <img src="<?= uploadUrl('products/' . $p['image']) ?>" class="w-100" style="height: 150px; object-fit: cover;">
                    <div class="p-3">
                        <h6 class="fw-bold text-truncate mb-1" style="font-size: 0.95rem;"><?= htmlspecialchars($p['name']) ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">RP <?= number_format($p['price'], 0, ',', '.') ?></span>
                            <small class="text-muted">Stok: <?= $p['stock'] ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom sticky-top" style="top: 100px; height: calc(100vh - 140px); display: flex; flex-direction: column;">
            <div class="d-flex align-items-center mb-4">
                <i class="fa-solid fa-cart-shopping me-2 text-primary"></i>
                <h5 class="fw-bold m-0">Current Order</h5>
            </div>

            <div id="cartItems" class="flex-grow-1 overflow-auto mb-4" style="padding-right: 5px;">
                <div class="text-center text-muted py-5" id="emptyCart">
                    <i class="fa-solid fa-basket-shopping fa-3x mb-3" style="opacity: 0.2;"></i>
                    <p>Keranjang masih kosong</p>
                </div>
                </div>

            <hr class="my-4">

            <div class="payment-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold" id="subtotalLabel">RP 0</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Tax (0%)</span>
                    <span class="fw-bold">RP 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-4" style="background: #0f172a; color: #D4AF37;">
                    <span class="fw-bold">TOTAL</span>
                    <h4 class="fw-bold m-0" id="totalLabel">RP 0</h4>
                </div>

                <form action="checkout.php" method="POST">
                    <input type="hidden" name="cart_data" id="cartDataInput">
                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold" style="background: #000; border: 1px solid #D4AF37; color: #D4AF37; border-radius: 12px; letter-spacing: 1px;">
                        PROCESS CHECKOUT <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>