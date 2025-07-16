<?php 
session_start();
include 'koneksi/koneksi.php';
if (isset($_SESSION['kd_cs'])) {
    $kode_cs = $_SESSION['kd_cs'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Lokalista</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff6b35;
            --secondary-color: #ff8c42;
            --accent-color: #ff9500;
            --text-dark: #333;
            --light-gray: #f5f5f5;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            --gradient-secondary: linear-gradient(135deg, #ff8c42 0%, #ff9500 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--light-gray);
        }

        /* Header Styles */
        .navbar {
            background: var(--gradient-primary);
            box-shadow: 0 2px 20px rgba(255, 107, 53, 0.3);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
            color: white !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 15px;
            padding: 10px 20px !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link.active::before {
            left: 0;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" fill-opacity="0.1"><path d="M0,20 Q250,80 500,20 T1000,20 V100 H0 Z"/></svg>');
            background-size: cover;
            background-position: bottom;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            animation: slideInDown 1s ease-out;
        }

        .hero-section p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            animation: slideInUp 1s ease-out 0.3s both;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 20px;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        /* Content Sections */
        .content-section {
            padding: 80px 0;
            position: relative;
        }

        .content-section:nth-child(even) {
            background: var(--white);
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 50px;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 5px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        .content-text {
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 30px;
            color: #555;
        }

        .highlight-box {
            background: var(--gradient-primary);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        /* Mission Vision Values */
        .mvv-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .mvv-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .mvv-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
        }

        .mvv-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.2);
            border-color: var(--primary-color);
        }

        .mvv-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
        }

        .mvv-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .mvv-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
        }

        /* Team Section */
        .team-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .team-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.2);
        }

        .team-image {
            width: 100%;
            height: 250px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 5rem;
            position: relative;
            overflow: hidden;
        }

        .team-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 30%, rgba(255,255,255,0.1) 100%);
        }

        .team-content {
            padding: 30px;
            text-align: center;
        }

        .team-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .team-position {
            font-size: 1.1rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .team-description {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: var(--gradient-primary);
            color: white;
            padding: 80px 0;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 60px 0 20px;
        }

        footer h4, footer h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }
            
            .hero-section p {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .content-section {
                padding: 50px 0;
            }
            
            .mvv-container,
            .team-container {
                grid-template-columns: 1fr;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store"></i> Lokalista
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">
                            <i class="fas fa-box"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tentang.php">
                            <i class="fas fa-info-circle"></i> Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">
                            <i class="fas fa-phone"></i> Kontak
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                    </li>
                    <?php if (isset($_SESSION['kd_cs'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Tentang Lokalista</h1>
                <p>Platform e-commerce #1 untuk produk lokal Indonesia terbaik</p>
                <div class="hero-badge">
                    <i class="fas fa-star"></i> Dipercaya Jutaan Pengguna
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-container">
                <div class="stat-item fade-in">
                    <span class="stat-number">100K+</span>
                    <span class="stat-label">Produk Tersedia</span>
                </div>
                <div class="stat-item fade-in">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Penjual Aktif</span>
                </div>
                <div class="stat-item fade-in">
                    <span class="stat-number">1M+</span>
                    <span class="stat-label">Pengguna Terdaftar</span>
                </div>
                <div class="stat-item fade-in">
                    <span class="stat-number">34</span>
                    <span class="stat-label">Provinsi Terjangkau</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="content-section">
        <div class="container">
            <h2 class="section-title fade-in">Siapa Kami</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <p class="content-text fade-in">
                        Lokalista adalah platform e-commerce terdepan yang didedikasikan untuk mengangkat dan mempromosikan produk-produk lokal Indonesia. Kami percaya bahwa setiap produk lokal memiliki cerita unik dan kualitas yang tidak kalah dengan produk impor.
                    </p>
                    <div class="highlight-box fade-in">
                        <h4><i class="fas fa-lightbulb"></i> Mengapa Lokalista?</h4>
                        <p>Kami hadir untuk menjembatani produsen lokal dengan konsumen yang mencari produk berkualitas, sekaligus mendukung pertumbuhan ekonomi Indonesia melalui UMKM yang berdaya saing tinggi.</p>
                    </div>
                    <p class="content-text fade-in">
                        Didirikan pada tahun 2024, Lokalista telah berkembang menjadi marketplace terpercaya dengan jutaan pengguna aktif. Kami berkomitmen untuk terus berinovasi dan memberikan pengalaman berbelanja terbaik bagi semua pengguna.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Values -->
    <section class="content-section">
        <div class="container">
            <h2 class="section-title fade-in">Misi, Visi & Nilai</h2>
            <div class="mvv-container">
                <div class="mvv-card fade-in">
                    <div class="mvv-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="mvv-title">Visi</h3>
                    <p class="mvv-text">
                        Menjadi platform e-commerce #1 di Indonesia yang mengangkat produk lokal ke kancah global dan membanggakan Indonesia.
                    </p>
                </div>
                <div class="mvv-card fade-in">
                    <div class="mvv-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="mvv-title">Misi</h3>
                    <p class="mvv-text">
                        Memberdayakan UMKM Indonesia dengan teknologi terdepan, menghubungkan jutaan pembeli dengan produk lokal berkualitas tinggi.
                    </p>
                </div>
                <div class="mvv-card fade-in">
                    <div class="mvv-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="mvv-title">Nilai</h3>
                    <p class="mvv-text">
                        Kualitas Premium, Kepercayaan Tinggi, Inovasi Berkelanjutan, dan Cinta Produk Indonesia yang tak tergoyahkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="content-section">
        <div class="container">
            <h2 class="section-title fade-in">Tim Hebat Kami</h2>
            <div class="team-container">
                <div class="team-card fade-in">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="team-content">
                        <h3 class="team-name">Eri Gunawan</h3>
                        <p class="team-position">CEO & Founder</p>
                        <p class="team-description">
                            Visioner berpengalaman 15 tahun di industri e-commerce yang memimpikan Indonesia menjadi pusat produk lokal berkualitas dunia.
                        </p>
                    </div>
                </div>
                <div class="team-card fade-in">
                    <div class="team-image">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="team-content">
                        <h3 class="team-name">Syifaul Nadila</h3>
                        <p class="team-position">Chief Technology Officer</p>
                        <p class="team-description">
                            Ahli teknologi yang memastikan platform Lokalista selalu menggunakan teknologi terdepan untuk pengalaman pengguna yang luar biasa.
                        </p>
                    </div>
                </div>
                <div class="team-card fade-in">
                    <div class="team-image">
                        <i class="fas fa-user-star"></i>
                    </div>
                    <div class="team-content">
                        <h3 class="team-name">Nia Ulfa</h3>
                        <p class="team-position">Head of Marketing</p>
                        <p class="team-description">
                            Strategi marketing kreatif yang telah berhasil memperkenalkan jutaan produk lokal kepada masyarakat Indonesia dan mancanegara.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Tentang Lokalista -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4><i class="fas fa-store"></i> Lokalista</h4>
                    <p>Platform e-commerce #1 yang mendukung produk lokal Indonesia dengan teknologi terdepan dan pelayanan terbaik.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Menu -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Menu Utama</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="produk.php">Produk</a></li>
                        <li><a href="tentang.php">Tentang</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                        <li><a href="keranjang.php">Keranjang</a></li>
                    </ul>
                </div>

                <!-- Layanan -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Layanan Pelanggan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Panduan Belanja</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>Hubungi Kami</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Sudirman No. 123, Jakarta Pusat</p>
                    <p><i class="fas fa-phone me-2"></i>+62 21 1234 5678</p>
                    <p><i class="fas fa-envelope me-2"></i>support@lokalista.id</p>
                    <p><i class="fas fa-clock me-2"></i>24/7 Customer Support</p>
                </div>
            </div>

            <hr style="border-color:#444; margin: 40px 0 20px;" />

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small>&copy; <?= date('Y'); ?> Lokalista - Bangga Produk Indonesia. All rights reserved.</small>
                <div class="mt-3 mt-md-0">
                    <i class="fab fa-cc-visa text-light fs-4 me-2"></i>
                    <i class="fab fa-cc-mastercard text-light fs-4 me-2"></i>
                    <i class="fab fa-cc-paypal text-light fs-4 me-2"></i>
                    <i class="fab fa-cc-amex text-light fs-4"></i>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Counter animation
        const counters = document.querySelectorAll('.stat-number');
        
        const countUp = (element, target) => {
            const count = parseInt(element.textContent.replace(/[^\d]/g, ''));
            const increment = Math.ceil(target / 100);
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                let displayValue = current.toLocaleString();
                if (element.textContent.includes('K')) {
                    displayValue += 'K+';
                } else if (element.textContent.includes('M')) {
                    displayValue += 'M+';
                } else if (current === target && !element.textContent.includes('+')) {
                    displayValue = target.toString();
                }
                
                element.textContent = displayValue;
            }, 20);
        };
        
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    const text = statNumber.textContent;
                    let target = parseInt(text.replace(/[^\d]/g, ''));
                    
                    if (text.includes('K')) {
                        target = target * 1000;
                    } else if (text.includes('M')) {
                        target = target * 1000000;
                    }
                    
                    countUp(statNumber, target);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.stat-item').forEach(item => {
            statsObserver.observe(item);
        });
    </script>
</body>
</html>