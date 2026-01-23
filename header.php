<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/helpers.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URBANLOKA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= assetUrl('css/modern.css') ?>">
</head>
<body>

<div class="app-wrapper">
    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-container">
        <nav style="height: 70px; display: flex; align-items: center; justify-content: flex-end; padding: 0 40px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 900;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="text-align: right;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a; line-height: 1;"><?= htmlspecialchars($_SESSION['fullname'] ?? 'User') ?></div>
                    <small style="font-size: 0.7rem; color: #64748b; text-transform: uppercase;"><?= $_SESSION['role'] ?? 'Guest' ?></small>
                </div>
                <div style="width: 38px; height: 38px; background: #000; color: #D4AF37; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 1px solid #e2e8f0;">
                    <?= strtoupper(substr($_SESSION['fullname'] ?? 'U', 0, 1)) ?>
                </div>
            </div>
        </nav>

        <main class="page-content">