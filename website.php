<?php 
require '../config/database.php';
require '../config/helpers.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Ambil company profile
$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM company_profile ORDER BY id DESC LIMIT 1"));

// Ambil featured products
$featured_products = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($profile['company_name'] ?? 'URBANLOKA') ?> - Urban Fashion Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --noir: #0b0f19;
            --gold: #D4AF37;
            --slate: #64748b;
            --soft-bg: #f8fafc;
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--soft-bg);
            color: var(--noir);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar-top {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand-custom {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--noir);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-brand-custom span {
            color: var(--gold);
        }

        /* Hero Section */
        .hero-section {
            background: var(--noir);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-section p {
            font-size: 1.25rem;
            color: #94a3b8;
            max-width: 600px;
            margin-bottom: 2rem;
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--noir);
            font-weight: 700;
            padding: 12px 32px;
            border-radius: 12px;
            border: none;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background-color: #b8962d;
            transform: translateY(-3px);
            color: white;
        }

        /* Product Card */
        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .section-subtitle {
            text-align: center;
            color: var(--slate);
            margin-bottom: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .product-image-wrapper {
            position: relative;
            padding: 15px;
        }

        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
        }

        .badge-limited {
            position: absolute;
            top: 25px;
            right: 25px;
            background: var(--noir);
            color: var(--gold);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .product-info {
            padding: 0 20px 25px 20px;
        }

        .product-category {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .product-name {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 10px;
            color: var(--noir);
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--noir);
        }

        /* About Section */
        .about-card {
            background: white;
            border-radius: 24px;
            padding: 4rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            margin-top: 5rem;
        }

        .strategy-box {
            padding: 25px;
            border-radius: 18px;
            height: 100%;
            transition: 0.3s;
        }

        .mission-box { background: #f0fdf4; border-left: 5px solid #22c55e; }
        .vision-box { background: #fffbeb; border-left: 5px solid #f59e0b; }

        /* Footer */
        .website-footer {
            background: var(--noir);
            color: white;
            padding: 80px 0 40px 0;
            margin-top: 100px;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .footer-brand span { color: var(--gold); }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-link:hover { color: var(--gold); }
    </style>
</head>
<body>
    <nav class="navbar-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="navbar-brand-custom">
                    <i class="fa-solid fa-crown me-2" style="color: var(--gold);"></i><?= htmlspecialchars($profile['company_name'] ?? 'URBAN') ?><span>LOKA</span>
                </a>
                <div class="d-none d-md-flex align-items-center gap-4">
                    <div style="font-size: 0.85rem; color: var(--slate);">
                        <i class="fa-solid fa-envelope me-2 text-dark"></i><?= htmlspecialchars($profile['email'] ?? '') ?>
                    </div>
                    <a href="../modules/auth/login.php" class="btn btn-outline-dark btn-sm px-4 fw-bold" style="border-radius: 8px;">ADMIN LOGIN</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge mb-3" style="background: rgba(212, 175, 55, 0.2); color: var(--gold); border: 1px solid var(--gold);">PREMIUM STREETWEAR</span>
                    <h1>Elevate Your Style <br>With Urban Context.</h1>
                    <p><?= htmlspecialchars($profile['description'] ?? 'Platform Fashion Urban Terbaik untuk koleksi kurasi eksklusif.') ?></p>
                    <a href="#collection" class="btn btn-gold">BROWSE COLLECTION</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="collection" style="margin-top: 80px;">
        <h2 class="section-title">Featured Drops</h2>
        <p class="section-subtitle">Koleksi terpilih yang mendefinisikan tren hari ini.</p>
        
        <div class="row g-4">
            <?php while ($product = mysqli_fetch_assoc($featured_products)): 
                $stock = (int)($product['stock'] ?? 0);
                $price = (int)($product['price'] ?? 0);
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="<?= uploadUrl('products/' . $product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <div class="badge-limited">FEATURED</div>
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?= htmlspecialchars($product['category_name'] ?? 'Koleksi') ?></span>
                        <h3 class="product-name text-truncate"><?= htmlspecialchars($product['name']) ?></h3>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="product-price">Rp <?= number_format($price, 0, ',', '.') ?></div>
                            <div class="small fw-bold <?= $stock < 5 ? 'text-danger' : 'text-muted' ?>">
                                <i class="fa-solid fa-box-open me-1"></i><?= $stock ?> left
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="container">
        <div class="about-card">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h6 class="text-uppercase fw-bold text-muted mb-2" style="letter-spacing: 2px;">Our Story</h6>
                    <h2 class="display-6 fw-bold mb-4">Membangun Identitas <br>Lewat Fashion.</h2>
                    <p class="text-muted lead mb-4"><?= htmlspecialchars($profile['about'] ?? '') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="strategy-box mission-box">
                                <h5 class="fw-bold mb-2">Our Mission</h5>
                                <p class="mb-0 small opacity-75"><?= htmlspecialchars($profile['mission'] ?? '') ?></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="strategy-box vision-box">
                                <h5 class="fw-bold mb-2">Our Vision</h5>
                                <p class="mb-0 small opacity-75"><?= htmlspecialchars($profile['vision'] ?? '') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="website-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="footer-brand">URBAN<span>LOKA</span></div>
                    <p style="color: #64748b; line-height: 1.8;">
                        <?= htmlspecialchars($profile['description'] ?? '') ?>
                    </p>
                    <div class="mt-4 d-flex gap-3">
                        <a href="#" class="footer-link"><i class="fa-brands fa-instagram fa-xl"></i></a>
                        <a href="#" class="footer-link"><i class="fa-brands fa-facebook fa-xl"></i></a>
                        <a href="#" class="footer-link"><i class="fa-brands fa-tiktok fa-xl"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-4">Shop</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">New Arrivals</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Best Sellers</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Sale Items</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 text-md-end">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <p style="color: #64748b;">
                        <?= htmlspecialchars($profile['address'] ?? '-') ?><br><br>
                        <strong>T.</strong> <?= htmlspecialchars($profile['phone'] ?? '') ?><br>
                        <strong>E.</strong> <?= htmlspecialchars($profile['email'] ?? '') ?>
                    </p>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center">
                <p class="small text-muted mb-0">
                    &copy; <?= date('Y') ?> <?= htmlspecialchars($profile['company_name'] ?? 'URBANLOKA') ?>. Designed for Urban Culture.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>