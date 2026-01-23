<?php 
require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

restrictToAdmin();

// Ambil data profil
$query = mysqli_query($conn, "SELECT * FROM company_profile LIMIT 1");
$profile = mysqli_fetch_assoc($query);

include '../../partials/header.php'; 
// STOP! Jangan include sidebar.php di sini karena sudah ada di dalam header.php
?>

<div class="mb-5">
    <h1 class="fw-bold" style="color: #1e293b; font-size: 2.2rem; letter-spacing: -1px;">Profil Perusahaan</h1>
    <p class="text-muted">Informasi identitas resmi dan visi misi <b><?= htmlspecialchars($profile['name'] ?? 'URBANLOKA') ?></b></p>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="text-center mb-4">
                <div style="width: 100px; height: 100px; background: #000; border-radius: 25px; display: inline-flex; align-items: center; justify-content: center; border: 2px solid #D4AF37; color: #D4AF37; margin-bottom: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-crown fa-3x"></i>
                </div>
                <h2 class="fw-bold" style="color: #0f172a;"><?= htmlspecialchars($profile['name'] ?? 'URBANLOKA') ?></h2>
                <span class="badge" style="background: #eef2ff; color: #6366f1; padding: 8px 16px; border-radius: 8px;">EST. <?= $profile['established_year'] ?? '2024' ?></span>
            </div>

            <hr style="opacity: 0.1; margin: 2rem 0;">

            <div class="mb-4">
                <label class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Alamat Kantor</label>
                <p class="fw-medium mt-1" style="color: #334155;"><i class="fa-solid fa-location-dot me-2 text-primary"></i> <?= htmlspecialchars($profile['address'] ?? '-') ?></p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Email</label>
                    <p class="fw-medium mt-1"><i class="fa-solid fa-envelope me-2 text-primary"></i> <?= htmlspecialchars($profile['email'] ?? '-') ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Telepon</label>
                    <p class="fw-medium mt-1"><i class="fa-solid fa-phone me-2 text-primary"></i> <?= htmlspecialchars($profile['phone'] ?? '-') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-custom mb-4" style="border-left: 5px solid #10b981;">
            <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-rocket me-2"></i> Misi</h5>
            <p style="color: #475569; line-height: 1.7;"><?= htmlspecialchars($profile['mission'] ?? 'Misi belum diatur.') ?></p>
        </div>

        <div class="card-custom" style="border-left: 5px solid #f59e0b;">
            <h5 class="fw-bold text-warning mb-3"><i class="fa-solid fa-eye me-2"></i> Visi</h5>
            <p style="color: #475569; line-height: 1.7;"><?= htmlspecialchars($profile['vision'] ?? 'Visi belum diatur.') ?></p>
        </div>

        <div class="mt-4">
            <a href="edit_profile.php" class="btn btn-dark w-100 py-3 fw-bold" style="background: #000; border: 1px solid #D4AF37; color: #D4AF37; border-radius: 12px;">
                <i class="fa-solid fa-pen-to-square me-2"></i> EDIT PROFIL PERUSAHAAN
            </a>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>