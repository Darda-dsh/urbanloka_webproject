<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

// Proteksi Admin
restrictToAdmin();

// 1. Ambil data profil saat ini dari database
$query = mysqli_query($conn, "SELECT * FROM company_profile LIMIT 1");
$profile = mysqli_fetch_assoc($query);

// 2. Proses Simpan atau Update Data
if (isset($_POST['update'])) {
    // Escaping string untuk keamanan tanda petik (')
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    
    // Logika agar tidak error "Incorrect integer value" jika input kosong
    $est     = !empty($_POST['established_year']) ? intval($_POST['established_year']) : 0;
    
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mission = mysqli_real_escape_string($conn, $_POST['mission']);
    $vision  = mysqli_real_escape_string($conn, $_POST['vision']);

    // Cek apakah data sudah ada (UPDATE) atau masih kosong (INSERT)
    if ($profile) {
        $sql = "UPDATE company_profile SET 
                name = '$name', 
                established_year = $est, 
                email = '$email', 
                phone = '$phone', 
                address = '$address', 
                mission = '$mission', 
                vision = '$vision' 
                WHERE id = " . $profile['id'];
    } else {
        $sql = "INSERT INTO company_profile (name, established_year, email, phone, address, mission, vision) 
                VALUES ('$name', $est, '$email', '$phone', '$address', '$mission', '$vision')";
    }

    // Eksekusi Query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profil Berhasil Diperbarui!'); window.location='company_profile.php';</script>";
        exit();
    } else {
        die("Gagal memperbarui data: " . mysqli_error($conn));
    }
}

include '../../partials/header.php'; 
?>

<div style="display: flex; justify-content: center; width: 100%; padding: 40px 0;">
    <div style="width: 100%; max-width: 850px;">
        
        <div class="mb-4 text-center">
            <h2 style="font-weight: 800; color: #1e293b; letter-spacing: -1px;">
                <i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Profil Perusahaan
            </h2>
            <p class="text-muted">Pastikan data yang dimasukkan sesuai dengan identitas resmi toko.</p>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #fff; overflow: hidden;">
            <div class="card-body p-5">
                <form method="POST">
                    <div class="row g-4">
                        
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-dark small text-uppercase">Nama Perusahaan / Toko</label>
                            <input type="text" name="name" class="form-control form-control-lg" 
                                   value="<?= $profile['name'] ?? '' ?>" required 
                                   style="border-radius: 12px; font-size: 1rem; background: #f8fafc;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark small text-uppercase">Tahun Berdiri</label>
                            <input type="number" name="established_year" class="form-control form-control-lg" 
                                   value="<?= $profile['established_year'] ?? '' ?>" 
                                   style="border-radius: 12px; font-size: 1rem; background: #f8fafc;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Email Bisnis</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= $profile['email'] ?? '' ?>" 
                                   style="border-radius: 10px; padding: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small text-uppercase">Nomor Telepon / WA</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?= $profile['phone'] ?? '' ?>" 
                                   style="border-radius: 10px; padding: 12px; background: #f8fafc;">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small text-uppercase">Alamat Headquarters</label>
                            <textarea name="address" class="form-control" rows="2" 
                                      style="border-radius: 10px; background: #f8fafc;"><?= $profile['address'] ?? '' ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-success small text-uppercase">Misi Perusahaan</label>
                            <textarea name="mission" class="form-control" rows="4" 
                                      style="border-radius: 10px; background: #f8fafc; border-left: 4px solid #198754;"><?= $profile['mission'] ?? '' ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-warning small text-uppercase">Visi Perusahaan</label>
                            <textarea name="vision" class="form-control" rows="4" 
                                      style="border-radius: 10px; background: #f8fafc; border-left: 4px solid #ffc107;"><?= $profile['vision'] ?? '' ?></textarea>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="d-flex gap-3">
                                <button type="submit" name="update" class="btn btn-dark flex-grow-1 py-3 fw-bold" 
                                        style="background: #000; border: 1px solid #D4AF37; color: #D4AF37; border-radius: 12px; letter-spacing: 1px;">
                                    <i class="fa-solid fa-save me-2"></i> SIMPAN PERUBAHAN
                                </button>
                                <a href="company_profile.php" class="btn btn-light px-4 py-3 fw-bold" 
                                   style="border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b;">
                                    BATAL
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>