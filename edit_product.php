<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

// Ambil ID produk yang akan diedit
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$p = mysqli_fetch_assoc($result);

if (!$p) {
    header("Location: index.php");
    exit;
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

if (isset($_POST['update'])) {
    // PROTEKSI: Gunakan real_escape_string untuk menangani tanda petik (') agar tidak error SQL
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $category_id = intval($_POST['category_id']);

    // Logika upload gambar
    if ($_FILES['image']['name'] != "") {
        $filename = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $new_filename = date('YmdHis') . '_' . $filename;
        $path = "../../uploads/products/" . $new_filename;

        if (move_uploaded_file($tmp_name, $path)) {
            // Hapus gambar lama jika ada dan filenya memang eksis di folder
            if (!empty($p['image'])) {
                $old_image_path = "../../uploads/products/" . $p['image'];
                if (file_exists($old_image_path)) {
                    @unlink($old_image_path);
                }
            }
            $img = $new_filename;
        } else {
            $img = $p['image'];
        }
    } else {
        $img = $p['image'];
    }

    $query = "UPDATE products SET 
              name = '$name', 
              sku_code = '$sku', 
              price = '$price', 
              stock = '$stock', 
              drop_status = '$status', 
              image = '$img',
              category_id = '$category_id'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        die("Error update: " . mysqli_error($conn));
    }
}

include '../../partials/header.php'; 
include '../../partials/sidebar.php'; 
?>

<div class="mb-4">
    <h1 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Edit Produk</h1>
    <p style="color: #64748b; font-size: 0.95rem;">Perbarui detail produk <strong><?= htmlspecialchars($p['name']) ?></strong> di gudang Anda.</p>
</div>

<div style="max-width: 700px;">
    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-box me-2" style="color: #6366f1;"></i>Nama Produk
                    </label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-barcode me-2" style="color: #6366f1;"></i>SKU
                        </label>
                        <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($p['sku_code']) ?>" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-tag me-2" style="color: #6366f1;"></i>Kategori
                        </label>
                        <select name="category_id" class="form-select" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($p['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-dollar-sign me-2" style="color: #6366f1;"></i>Harga (Rp)
                        </label>
                        <input type="number" name="price" class="form-control" value="<?= $p['price'] ?>" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-boxes-stacked me-2" style="color: #6366f1;"></i>Stok
                        </label>
                        <input type="number" name="stock" class="form-control" value="<?= $p['stock'] ?>" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-star me-2" style="color: #6366f1;"></i>Status Drop
                    </label>
                    <select name="status" class="form-select" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        <option value="General" <?= ($p['drop_status'] == 'General') ? 'selected' : '' ?>>General Release</option>
                        <option value="Limited" <?= ($p['drop_status'] == 'Limited') ? 'selected' : '' ?>>Limited Drop</option>
                    </select>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-image me-2" style="color: #6366f1;"></i>Gambar Produk
                    </label>
                    <div class="d-flex align-items-center gap-3 p-3" style="border: 2px dashed #e2e8f0; border-radius: 0.75rem;">
                        <?php if($p['image']): ?>
                            <img src="<?= uploadUrl('products/' . $p['image']) ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 0.5rem;">
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <input type="file" name="image" class="form-control border-0" accept="image/*">
                            <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti gambar lama.</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" name="update" class="btn btn-dark flex-grow-1" style="background: #000; border: 1px solid #D4AF37; color: #D4AF37; padding: 1rem; font-weight: 700; border-radius: 0.75rem;">
                        <i class="fa-solid fa-save me-2"></i>UPDATE DATA PRODUK
                    </button>
                    <a href="index.php" class="btn btn-light" style="padding: 1rem; font-weight: 600; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>