<?php 
require '../config/database.php';
require '../config/helpers.php';
require '../session_check.php';

// Ambil company profile
$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_profile ORDER BY id DESC LIMIT 1"));

$notif = null;

// Handle update
if (isset($_POST['update'])) {
    $company_name = trim($_POST['company_name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $established_year = intval($_POST['established_year']);
    $mission = trim($_POST['mission']);
    $vision = trim($_POST['vision']);
    $about = trim($_POST['about']);
    
    if ($company_name && $description) {
        $query = "UPDATE company_profile SET 
                  company_name = '$company_name',
                  description = '$description',
                  address = '$address',
                  phone = '$phone',
                  email = '$email',
                  established_year = $established_year,
                  mission = '$mission',
                  vision = '$vision',
                  about = '$about'
                  WHERE id = " . $profile['id'];
        
        if (mysqli_query($conn, $query)) {
            $notif = ['success', 'Profil perusahaan berhasil diperbarui!'];
            // Refresh data
            $profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_profile WHERE id = " . $profile['id']));
        } else {
            $notif = ['danger', 'Gagal memperbarui profil: ' . mysqli_error($conn)];
        }
    } else {
        $notif = ['warning', 'Nama perusahaan dan deskripsi tidak boleh kosong!'];
    }
}

include '../partials/header.php';
include '../partials/sidebar.php';
?>

<h1 style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Pengaturan Profil Perusahaan</h1>
<p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">Kelola informasi profil perusahaan dan CMS</p>

<div style="max-width: 900px;">
    <?php if ($notif): ?>
        <div class="alert alert-<?= $notif[0] ?> alert-dismissible fade show" role="alert" style="margin-bottom: 2rem;">
            <i class="fa-solid fa-<?= $notif[0] === 'success' ? 'check-circle' : ($notif[0] === 'danger' ? 'exclamation-circle' : 'triangle-exclamation') ?> me-2"></i>
            <?= htmlspecialchars($notif[1]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); border: none; padding: 1.5rem;">
            <h5 style="color: white; margin: 0; font-weight: 700;">
                <i class="fa-solid fa-cog me-2"></i>Edit Informasi Perusahaan
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" novalidate>
                <!-- Row 1: Company Name & Email -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-building me-2" style="color: #6366f1;"></i>Nama Perusahaan
                        </label>
                        <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($profile['company_name'] ?? '') ?>" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-envelope me-2" style="color: #6366f1;"></i>Email
                        </label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                </div>

                <!-- Row 2: Phone & Established Year -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-phone me-2" style="color: #6366f1;"></i>Nomor Telepon
                        </label>
                        <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                    <div>
                        <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-calendar me-2" style="color: #6366f1;"></i>Tahun Berdiri
                        </label>
                        <input type="number" name="established_year" class="form-control" value="<?= $profile['established_year'] ?? '' ?>" min="1900" max="<?= date('Y') ?>" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                    </div>
                </div>

                <!-- Address -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-location-dot me-2" style="color: #6366f1;"></i>Alamat
                    </label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem;">
                </div>

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-align-left me-2" style="color: #6366f1;"></i>Deskripsi Singkat
                    </label>
                    <textarea name="description" class="form-control" rows="3" required style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; resize: vertical;"><?= htmlspecialchars($profile['description'] ?? '') ?></textarea>
                    <small style="color: #94a3b8; display: block; margin-top: 0.5rem;">Deskripsi singkat tentang perusahaan</small>
                </div>

                <!-- Mission -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-arrow-right me-2" style="color: #10b981;"></i>Misi
                    </label>
                    <textarea name="mission" class="form-control" rows="3" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; resize: vertical;"><?= htmlspecialchars($profile['mission'] ?? '') ?></textarea>
                </div>

                <!-- Vision -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-star me-2" style="color: #f59e0b;"></i>Visi
                    </label>
                    <textarea name="vision" class="form-control" rows="3" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; resize: vertical;"><?= htmlspecialchars($profile['vision'] ?? '') ?></textarea>
                </div>

                <!-- About -->
                <div style="margin-bottom: 2rem;">
                    <label class="form-label" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-circle-info me-2" style="color: #6366f1;"></i>Tentang Kami (Halaman Lengkap)
                    </label>
                    <textarea name="about" class="form-control" rows="5" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; resize: vertical;"><?= htmlspecialchars($profile['about'] ?? '') ?></textarea>
                    <small style="color: #94a3b8; display: block; margin-top: 0.5rem;">Deskripsi lengkap tentang perusahaan (mendukung multiple paragraf)</small>
                </div>

                <!-- Info Box -->
                <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <p style="color: #047857; margin: 0; font-size: 0.95rem;">
                        <i class="fa-solid fa-info-circle me-2"></i><strong>Info:</strong> Semua perubahan akan otomatis ditampilkan di halaman Profil Perusahaan dan menu yang mengikuti data ini.
                    </p>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" name="update" class="btn btn-primary" style="padding: 1rem 2rem; font-weight: 600; border-radius: 0.75rem;">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= url('modules/analytics/company_profile.php') ?>" class="btn btn-outline-primary" style="padding: 1rem 2rem; font-weight: 600; border-radius: 0.75rem; text-decoration: none;">
                        <i class="fa-solid fa-eye me-2"></i>Lihat Profil
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Last Updated Info -->
    <div style="margin-top: 2rem; text-align: center; color: #94a3b8; font-size: 0.9rem;">
        <i class="fa-solid fa-clock me-1"></i>Terakhir diperbarui: <?= date('d F Y, H:i', strtotime($profile['updated_at'] ?? 'now')) ?>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
