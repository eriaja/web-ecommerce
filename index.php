<?php 
session_start();
include 'koneksi/koneksi.php';

$kode_cs = $_SESSION['kd_cs'] ?? null;
$nama_cs = $_SESSION['user'] ?? null;
$cari = $_GET['cari'] ?? '';
$kategori_aktif = $_GET['kategori'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Lokalista – Etalase Produk Lokal Terbaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap & FontAwesome & AOS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-color: #ee4d2d;
            --secondary-color: #ffc107;
            --shopee-orange: #ff6b35;
            --shopee-light: #fff5f5;
            --background-light: #f5f5f5;
            --background-dark: #121212;
            --text-light: #fff;
            --text-dark: #333;
            --border-color: #e5e5e5;
            --shadow-light: rgba(0, 0, 0, 0.08);
            --shadow-hover: rgba(0, 0, 0, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: var(--background-light);
            color: var(--text-dark);
            padding-top: 70px;
            transition: background 0.4s, color 0.4s;
            margin: 0;
            line-height: 1.6;
        }

        body.dark-mode {
            background: var(--background-dark);
            color: var(--text-light);
        }

        /* Loader */
        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: var(--background-light);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }
        #loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
        #loader .spinner-border {
            width: 4rem;
            height: 4rem;
            color: var(--primary-color);
        }

        /* Navbar - Shopee Style */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            color: var(--text-light) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            color: var(--secondary-color);
        }
        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: var(--secondary-color) !important;
        }
        .btn-darkmode {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
            color: var(--text-light);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-darkmode:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
            border-color: var(--secondary-color);
        }

        /* Hero Video */
        .hero-video {
            position: relative;
            height: 70vh;
            overflow: hidden;
            margin-bottom: 30px;
            border-radius: 0 0 20px 20px;
        }
        .hero-video video {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.6);
            z-index: -1;
        }
        .hero-content {
            position: relative;
            color: var(--text-light);
            text-align: center;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .hero-content .btn {
            border-radius: 30px;
            padding: 15px 50px;
            font-weight: 700;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--secondary-color), #ffb000);
            color: var(--primary-color);
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        .hero-content .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }

        /* Search Section */
        .search-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px var(--shadow-light);
        }
        .search-section .form-control {
            border-radius: 25px;
            border: 2px solid var(--border-color);
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .search-section .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
        }
        .search-section .btn {
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .search-section .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(238, 77, 45, 0.3);
        }

        /* Filter Categories - Shopee Style */
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px var(--shadow-light);
        }
        .filter-scroll {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }
        .filter-scroll::-webkit-scrollbar {
            height: 4px;
        }
        .filter-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .filter-scroll::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        .filter-scroll a {
            display: inline-block;
            margin-right: 12px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 25px;
            padding: 8px 20px;
            border: 2px solid var(--border-color);
            color: var(--text-dark);
            transition: all 0.3s ease;
            text-decoration: none;
            background: white;
        }
        .filter-scroll a.active {
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(238, 77, 45, 0.3);
        }
        .filter-scroll a:hover:not(.active) {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        /* Products Grid - Shopee Style */
        .products-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px var(--shadow-light);
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Product Card - Enhanced Shopee Style */
        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px var(--shadow-light);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            border: 1px solid var(--border-color);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px var(--shadow-hover);
            border-color: var(--primary-color);
        }
        
        .product-image-container {
            position: relative;
            overflow: hidden;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .product-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            color: white;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 10;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .product-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .product-title {
            font-size: 14px;
            font-weight: 500;
            line-height: 1.3;
            height: 2.6em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 8px;
            color: var(--text-dark);
            text-decoration: none;
        }
        
        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        
        .product-extra {
            font-size: 12px;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 12px;
        }
        
        .product-buttons {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }
        
        .btn-detail, .btn-cart {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        
        .btn-detail {
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            color: white;
        }
        .btn-detail:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(238, 77, 45, 0.3);
            color: white;
        }
        
        .btn-cart {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        .btn-cart:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            --border-color: #333;
            --shadow-light: rgba(255, 255, 255, 0.1);
            --shadow-hover: rgba(255, 255, 255, 0.2);
        }
        
        body.dark-mode .search-section,
        body.dark-mode .filter-section,
        body.dark-mode .products-container {
            background: #1e1e1e;
            color: var(--text-light);
        }
        
        body.dark-mode .product-card {
            background: #1e1e1e;
            border-color: #333;
            color: var(--text-light);
        }
        
        body.dark-mode .product-title {
            color: var(--text-light);
        }
        
        body.dark-mode .filter-scroll a {
            background: #1e1e1e;
            color: var(--text-light);
            border-color: #333;
        }
        
        body.dark-mode .filter-scroll a:hover:not(.active) {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .no-results i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        .no-results h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .no-results p {
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Footer */
        footer {
            margin-top: 60px;
            padding: 30px 0;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), var(--shopee-orange));
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero-content p {
                font-size: 1.1rem;
            }
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 15px;
            }
            .search-section {
                padding: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 12px;
            }
            .product-card {
                border-radius: 8px;
            }
            .product-image {
                height: 160px;
            }
            .product-content {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<!-- Loader -->
<div id="loader">
    <div class="spinner-border" role="status"></div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-store"></i> Lokalista</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                <li class="nav-item"><a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart"></i></a></li>
                <?php if ($kode_cs): ?>
                    <li class="nav-item"><a class="nav-link" href="#">Halo, <?= htmlspecialchars($nama_cs); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="user_login.php">Login</a></li>
                <?php endif; ?>
                <li class="nav-item ms-3">
                    <button class="btn btn-darkmode" onclick="toggleDarkMode()" title="Toggle Dark Mode">🌙</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Video Section -->
<section class="hero-video">
    <video autoplay muted loop playsinline>
        <source src="image/home/hero.mp4" type="video/mp4" />
        Browser anda tidak mendukung video.
    </video>
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1200">
        <h1>Selamat Datang di Lokalista</h1>
        <p>Etalase produk lokal terbaik Indonesia</p>
        <a href="#produk" class="btn">Lihat Produk</a>
    </div>
</section>

<!-- Produk Section -->
<section id="produk" class="container">
    <!-- Search Section -->
    <div class="search-section" data-aos="fade-up" data-aos-duration="800">
        <form method="GET" class="d-flex gap-3 align-items-center">
            <div class="flex-grow-1">
                <input 
                    type="text" 
                    class="form-control" 
                    name="cari" 
                    placeholder="Cari produk lokal favoritmu..." 
                    value="<?= htmlspecialchars($cari) ?>" 
                    aria-label="Cari produk"
                />
            </div>
            <button type="submit" class="btn" aria-label="Cari">
                <i class="fas fa-search me-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Filter Categories -->
    <div class="filter-section" data-aos="fade-up" data-aos-duration="900">
        <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Kategori</h5>
        <div class="filter-scroll">
            <a href="index.php" class="<?= $kategori_aktif == '' ? 'active' : '' ?>">
                <i class="fas fa-th-large me-1"></i>Semua Produk
            </a>
            <?php
            $kategori_query = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk WHERE kategori != '' ORDER BY kategori ASC");
            while ($kat = mysqli_fetch_assoc($kategori_query)) : ?>
                <a href="?kategori=<?= urlencode($kat['kategori']); ?>" 
                   class="<?= $kategori_aktif == $kat['kategori'] ? 'active' : '' ?>">
                    <?= htmlspecialchars($kat['kategori']); ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Products Container -->
    <div class="products-container" data-aos="fade-up" data-aos-duration="1000">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="fas fa-shopping-bag me-2"></i>
                <?php if (!empty($cari)): ?>
                    Hasil pencarian "<?= htmlspecialchars($cari); ?>"
                <?php elseif (!empty($kategori_aktif)): ?>
                    Kategori: <?= htmlspecialchars($kategori_aktif); ?>
                <?php else: ?>
                    Semua Produk
                <?php endif; ?>
            </h5>
            <small class="text-muted">
                <?php
                $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
                $count = mysqli_fetch_assoc($count_query)['total'];
                echo $count . ' produk tersedia';
                ?>
            </small>
        </div>

        <div class="products-grid">
            <?php
            $where = [];
            if (!empty($cari)) {
                $safe_cari = mysqli_real_escape_string($conn, $cari);
                $where[] = "(nama LIKE '%$safe_cari%' OR deskripsi LIKE '%$safe_cari%' OR kategori LIKE '%$safe_cari%')";
            }
            if (!empty($kategori_aktif)) {
                $safe_kategori = mysqli_real_escape_string($conn, $kategori_aktif);
                $where[] = "kategori = '$safe_kategori'";
            }
            $where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";
            $result = mysqli_query($conn, "SELECT * FROM produk $where_sql ORDER BY nama ASC");

            if (mysqli_num_rows($result) == 0) {
                echo '
                <div class="no-results w-100">
                    <i class="fas fa-search"></i>
                    <h3>Produk Tidak Ditemukan</h3>
                    <p>Maaf, produk yang Anda cari tidak ditemukan. Silakan coba dengan kata kunci lain.</p>
                </div>';
            }

            while ($row = mysqli_fetch_assoc($result)) :
                $terjual = rand(10, 500);
                $rating = rand(40, 50) / 10; // Rating 4.0-5.0
                $full_stars = floor($rating);
                $half_star = ($rating - $full_stars) >= 0.5;
                $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                
                $stars = str_repeat('★', $full_stars);
                if ($half_star) $stars .= '☆';
                $stars .= str_repeat('☆', $empty_stars);
            ?>
                <div class="product-card" data-aos="fade-up" data-aos-duration="600">
                    <div class="product-image-container">
                        <div class="product-label">Terbaru</div>
                        <img 
                            src="image/produk/<?= $row['image']; ?>" 
                            alt="<?= htmlspecialchars($row['nama']); ?>" 
                            class="product-image" 
                            loading="lazy"
                        />
                    </div>
                    <div class="product-content">
                        <a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="product-title">
                            <?= htmlspecialchars($row['nama']); ?>
                        </a>
                        <div class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                        <div class="product-extra">
                            <span><i class="fas fa-shopping-cart me-1"></i><?= $terjual; ?> terjual</span>
                            <span class="rating-stars" title="Rating: <?= $rating; ?>/5">
                                <?= $stars; ?> (<?= $rating; ?>)
                            </span>
                        </div>
                        <div class="product-buttons">
                            <a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <?php if ($kode_cs): ?>
                                <a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn-cart">
                                    <i class="fas fa-cart-plus"></i> Keranjang
                                </a>
                            <?php else: ?>
                                <a href="user_login.php" class="btn-cart">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p class="mb-0">&copy; <?= date('Y'); ?> Lokalista – Bangga Produk Lokal Indonesia 🇮🇩</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Loader
    window.addEventListener("load", () => {
        const loader = document.getElementById("loader");
        loader.classList.add("hidden");
        setTimeout(() => loader.style.display = "none", 300);
    });

    // Dark Mode Toggle
    function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");
        const button = document.querySelector('.btn-darkmode');
        if (document.body.classList.contains('dark-mode')) {
            button.innerHTML = '☀️';
        } else {
            button.innerHTML = '🌙';
        }
        // Save preference
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    }

    // Load dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        document.querySelector('.btn-darkmode').innerHTML = '☀️';
    }

    // Init AOS animation
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>