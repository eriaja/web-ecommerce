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
    <title>Produk – Lokalista | Etalase Produk Lokal Terbaik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f8f9fa;
            color: #333;
            padding-top: 80px;
        }
        .navbar {
            background-color: #335C67;
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: white !important;
        }
        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            transition: 0.2s ease;
            overflow: hidden;
            position: relative;
            width: 220px;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            border-color: #f57224;
            box-shadow: 0 0 10px rgba(245,114,36,0.3);
        }
        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .product-content {
            padding: 10px;
            flex-grow: 1;
        }
        .product-title {
            font-size: 1rem;
            font-weight: 600;
            height: 42px;
            overflow: hidden;
            line-height: 1.2em;
            margin-bottom: 8px;
        }
        .product-price {
            color: #f57224;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .product-extra {
            font-size: 0.85rem;
            color: #777;
            margin-top: 5px;
        }
        .product-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #f57224;
            color: white;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 10;
        }
        .product-buttons {
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .btn-detail {
            background: #335C67;
            color: white;
            border-radius: 25px;
            padding: 6px 15px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-cart {
            background: #28a745;
            color: white;
            border-radius: 25px;
            padding: 6px 15px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-scroll {
            overflow-x: auto;
            white-space: nowrap;
            margin-bottom: 1rem;
            padding-bottom: 8px;
        }
        .filter-scroll a {
            display: inline-block;
            margin-right: 8px;
            padding: 6px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            text-decoration: none;
            color: #f57224;
            border: 1.5px solid #f57224;
            transition: all 0.3s ease;
        }
        .filter-scroll a.active, .filter-scroll a:hover {
            background: #f57224;
            color: white;
            border-color: #f57224;
        }
        .rating-stars {
            color: #ffcc00;
            font-size: 0.85rem;
        }
        footer {
            margin-top: 60px;
            border-top: 4px solid #335C67;
            background-color: #f8f9fa;
            color: #555;
            text-align: center;
            padding: 20px 0;
        }
        @media (max-width: 768px) {
            .product-card {
                width: 48%;
            }
        }
        @media (max-width: 480px) {
            .product-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-store"></i> Lokalista</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="produk.php" class="nav-link">Produk</a></li>
                <li class="nav-item"><a href="tentang.php" class="nav-link">Tentang</a></li>
                <li class="nav-item"><a href="kontak.php" class="nav-link">Kontak</a></li>
                <li class="nav-item">
                    <a href="<?= $kode_cs ? '#' : 'user_login.php' ?>" class="nav-link">
                        <?= $kode_cs ? "Halo, " . htmlspecialchars($nama_cs) : "Login" ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Tombol kembali -->
    <div class="mb-3">
        <a href="index.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <h2 class="text-center mb-4">Produk Lokalista</h2>

    <!-- Filter Kategori -->
    <?php $kategori_query = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk WHERE kategori != '' ORDER BY kategori ASC"); ?>
    <div class="filter-scroll mb-3">
        <a href="produk.php" class="<?= $kategori_aktif == '' ? 'active' : '' ?>">Semua</a>
        <?php while ($kat = mysqli_fetch_assoc($kategori_query)) { ?>
            <a href="?kategori=<?= urlencode($kat['kategori']); ?>" class="<?= $kategori_aktif == $kat['kategori'] ? 'active' : '' ?>">
                <?= htmlspecialchars($kat['kategori']); ?>
            </a>
        <?php } ?>
    </div>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-4 d-flex gap-2">
        <input type="text" class="form-control" name="cari" placeholder="Cari produk lokal..." value="<?= htmlspecialchars($cari) ?>" />
        <button type="submit" class="btn btn-warning px-4"><i class="fas fa-search"></i></button>
    </form>

    <!-- Daftar Produk -->
    <div class="d-flex flex-wrap gap-3 justify-content-start">
        <?php
        $where = [];
        if (!empty($cari)) {
            $safe_cari = mysqli_real_escape_string($conn, $cari);
            $where[] = "(nama LIKE '%$safe_cari%' OR deskripsi LIKE '%$safe_cari%')";
        }
        if (!empty($kategori_aktif)) {
            $safe_kategori = mysqli_real_escape_string($conn, $kategori_aktif);
            $where[] = "kategori = '$safe_kategori'";
        }
        $where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";
        $result = mysqli_query($conn, "SELECT * FROM produk $where_sql ORDER BY nama ASC");

        if (mysqli_num_rows($result) == 0) {
            echo '<div class="alert alert-warning w-100 text-center">Produk tidak ditemukan 😥</div>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $terjual = rand(5, 100);
            $rating = 4;
            $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
        ?>
            <div class="product-card">
                <div class="product-label">Baru</div>
                <img src="image/produk/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['nama']); ?>" class="product-image" />
                <div class="product-content">
                    <div class="product-title"><?= htmlspecialchars($row['nama']); ?></div>
                    <div class="product-price">Rp <?= number_format($row['harga']); ?></div>
                    <div class="product-extra">
                        Terjual: <?= $terjual; ?> | <span class="rating-stars"><?= $stars; ?></span>
                    </div>
                </div>
                <div class="product-buttons">
                    <a href="detail_produk.php?produk=<?= $row['kode_produk']; ?>" class="btn-detail">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <?php if ($kode_cs): ?>
                        <a href="proses/add.php?produk=<?= $row['kode_produk']; ?>&kd_cs=<?= $kode_cs; ?>&hal=1" class="btn-cart">
                            <i class="fas fa-cart-plus"></i> Tambah
                        </a>
                    <?php else: ?>
                        <a href="user_login.php" class="btn-cart">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <?= date('Y'); ?> Lokalista – Bangga Produk Lokal Indonesia.</p>
    <p><a href="index.php" class="text-decoration-none"><i class="fas fa-home"></i> Kembali ke Beranda</a></p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
