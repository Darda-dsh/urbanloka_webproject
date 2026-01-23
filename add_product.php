<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

// Notifikasi
$notif = null;
// Ambil kategori
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
if (isset($_POST['save'])) {
    $name = trim($_POST['name']);
    $sku = trim($_POST['sku']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $status = $_POST['status'];
    $category_id = intval($_POST['category_id']);
    $img = $_FILES['image']['name'];
    // Validasi sederhana
    if ($name && $sku && $price > 0 && $stock >= 0 && $img && $category_id > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/products/" . $img);
        $query = "INSERT INTO products (name, sku_code, price, stock, drop_status, image, category_id) VALUES ('$name', '$sku', '$price', '$stock', '$status', '$img', '$category_id')";
        if(mysqli_query($conn, $query)) {
            $notif = ['success', 'Produk berhasil ditambahkan!'];
        } else {
            $notif = ['danger', 'Gagal menambah produk: ' . mysqli_error($conn)];
        }
    } else {
        $notif = ['warning', 'Data tidak lengkap atau tidak valid!'];
    }
}
?>
<?php include '../../partials/header.php'; ?>
<?php include '../../partials/sidebar.php'; ?>
<h1 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Tambah Produk Baru</h1>
<p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">Masukkan detail produk untuk menambahkan ke gudang.</p>

<div style="max-width: 600px;">
    <?php if ($notif): ?>
        <div class="alert alert-<?= $notif[0] ?> alert-dismissible fade show" role="alert" style="margin-bottom: 2rem;">
            <i class="fa-solid fa-<?= $notif[0] === 'success' ? 'check-circle' : ($notif[0] === 'danger' ? 'exclamation-circle' : 'triangle-exclamation') ?> me-2"></i>
            <?= htmlspecialchars($notif[1]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" novalidate>
                <!-- Nama Produk -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-box me-2" style="color: #6366f1;"></i>Nama Produk
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Urban T-Shirt" required minlength="3" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                </div>

                <!-- SKU dan Kategori -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-barcode me-2" style="color: #6366f1;"></i>SKU
                        </label>
                        <input type="text" name="sku" class="form-control" placeholder="UL-001" required pattern="[A-Za-z0-9\-]+" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-tag me-2" style="color: #6366f1;"></i>Kategori
                        </label>
                        <select name="category_id" class="form-select" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Harga dan Stok -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-dollar-sign me-2" style="color: #6366f1;"></i>Harga (Rp)
                        </label>
                        <input type="number" name="price" class="form-control" placeholder="0" required min="1" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-boxes-stacked me-2" style="color: #6366f1;"></i>Stok Awal
                        </label>
                        <input type="number" name="stock" class="form-control" placeholder="0" required min="0" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                </div>

                <!-- Status Drop -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-star me-2" style="color: #6366f1;"></i>Status Drop
                    </label>
                    <select name="status" class="form-select" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        <option value="General">General Release</option>
                        <option value="Limited">Limited Drop</option>
                    </select>
                </div>

                <!-- Gambar Produk -->
                <div style="margin-bottom: 2rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-image me-2" style="color: #6366f1;"></i>Gambar Produk
                    </label>
                    <input type="file" name="image" class="form-control" required accept="image/*" style="border: 2px dashed #e2e8f0; border-radius: 0.75rem; padding: 1rem; cursor: pointer;">
                    <small style="color: #94a3b8; display: block; margin-top: 0.5rem;">Format: JPG, PNG, GIF (Maksimal 5MB)</small>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" name="save" class="btn btn-primary" style="flex: 1; padding: 1rem; font-weight: 600; border-radius: 0.75rem;">
                        <i class="fa-solid fa-save me-2"></i>Simpan Produk
                    </button>
                    <a href="index.php" class="btn btn-outline-primary" style="flex: 1; padding: 1rem; font-weight: 600; border-radius: 0.75rem; text-align: center; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include '../../partials/footer.php'; ?>
