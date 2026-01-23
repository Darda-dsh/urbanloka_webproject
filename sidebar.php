<?php 
// Ambil nama file dan nama folder untuk validasi menu active
$current_page = basename($_SERVER['PHP_SELF']);
$current_path = $_SERVER['PHP_SELF'];
$role = $_SESSION['role'] ?? 'kasir';
?>
<nav class="sidebar-nav">
    <div class="p-4 mb-3" style="border-bottom: 1px solid rgba(212, 175, 55, 0.1);">
        <a href="#" class="d-flex align-items-center text-decoration-none" style="color: var(--gold);">
            <i class="fa-solid fa-crown fa-xl me-2"></i>
            <span class="fw-bold tracking-widest" style="font-size: 1.2rem; letter-spacing: 2px;">URBANLOKA</span>
        </a>
    </div>

    <div class="flex-grow-1 overflow-auto">
        <?php if ($role === 'admin'): ?>
            <small class="px-4 text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Management</small>
            
            <a href="<?= moduleUrl('analytics', 'dashboard.php') ?>" 
               class="nav-item-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line me-3"></i><span>Dashboard</span>
            </a>
            
            <a href="<?= moduleUrl('analytics', 'company_profile.php') ?>" 
               class="nav-item-link <?= ($current_page == 'company_profile.php') ? 'active' : '' ?>">
                <i class="fa-solid fa-building me-3"></i><span>Company Profile</span>
            </a>
        <?php endif; ?>

        <small class="px-4 text-uppercase text-muted fw-bold d-block mt-4 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Store Operations</small>
        
        <a href="<?= moduleUrl('warehouse', 'index.php') ?>" 
           class="nav-item-link <?= ($current_page == 'index.php' && strpos($current_path, 'warehouse') !== false) ? 'active' : '' ?>">
            <i class="fa-solid fa-boxes-stacked me-3"></i><span>Warehouse</span>
        </a>
        
        <a href="<?= moduleUrl('terminal', 'index.php') ?>" 
           class="nav-item-link <?= ($current_page == 'index.php' && strpos($current_path, 'terminal') !== false) ? 'active' : '' ?>">
            <i class="fa-solid fa-cash-register me-3"></i><span>POS Terminal</span>
        </a>
        
        <a href="<?= moduleUrl('terminal', 'history.php') ?>" 
           class="nav-item-link <?= ($current_page == 'history.php') ? 'active' : '' ?>">
            <i class="fa-solid fa-receipt me-3"></i><span>History</span>
        </a>
    </div>

    <div class="p-4" style="border-top: 1px solid rgba(212, 175, 55, 0.1);">
        <div class="d-flex align-items-center mb-3">
            <div class="me-2" style="width: 35px; height: 35px; background: var(--gold); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #000;">
                <?= strtoupper(substr($_SESSION['fullname'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="overflow-hidden">
                <div class="text-white small fw-bold text-truncate" style="max-width: 150px;"><?= htmlspecialchars($_SESSION['fullname']) ?></div>
                <div class="text-muted" style="font-size: 0.7rem;"><?= strtoupper($role) ?></div>
            </div>
        </div>
        <a href="<?= url('logout.php') ?>" class="btn btn-outline-danger btn-sm w-100 border-0" style="background: rgba(220, 38, 38, 0.1);">
            <i class="fa-solid fa-power-off me-2"></i>Logout
        </a>
    </div>
</nav>