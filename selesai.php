<?php
include 'koneksi/koneksi.php';
$kode_order = $_GET['order'] ?? '';

// Cek apakah order ada
$order = mysqli_query($conn, "SELECT * FROM orders WHERE kode_order = '$kode_order'");
$data = mysqli_fetch_assoc($order);

$items = mysqli_query($conn, "SELECT * FROM order_detail WHERE kode_order = '$kode_order'");

if (!$data) {
    echo "<h3 style='text-align:center;color:red;'>Pesanan tidak ditemukan.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Selesai - Lokalista</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 3rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        .success-icon {
            font-size: 3rem;
            color: #00b894;
        }

        .btn-primary {
            background: #ee4d2d;
            border: none;
        }

        .order-item {
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        .btn-group {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-outline-secondary {
            border: 2px solid #ee4d2d;
            color: #ee4d2d;
        }

        .btn-outline-secondary:hover {
            background: #ee4d2d;
            color: white;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="success-icon mb-3">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2>Pesanan Berhasil!</h2>
    <p class="text-muted">
        Terima kasih, pesanan kamu telah diterima dengan nomor <strong><?= htmlspecialchars($data['kode_order']) ?></strong>.
    </p>

    <div class="text-start mt-4">
        <h5>Ringkasan Pesanan</h5>
        <hr>
        <?php
        $grandTotal = 0;
        while ($item = mysqli_fetch_assoc($items)) {
            $subtotal = $item['qty'] * $item['harga'];
            $grandTotal += $subtotal;
            echo '
            <div class="order-item d-flex justify-content-between">
                <div>
                    <div class="item-name">'.htmlspecialchars($item['nama_produk']).'</div>
                    <div class="text-muted">Qty: '.$item['qty'].' x Rp '.number_format($item['harga']).'</div>
                </div>
                <div class="item-price">Rp '.number_format($subtotal).'</div>
            </div>';
        }
        ?>
        <div class="d-flex justify-content-between mt-3">
            <strong>Total</strong>
            <strong>Rp <?= number_format($grandTotal) ?></strong>
        </div>
    </div>

    <div class="btn-group">
        <a href="index.php" class="btn btn-primary mt-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <a href="struk.php?order=<?= urlencode($kode_order) ?>" class="btn btn-outline-secondary mt-4">
            <i class="fas fa-file-invoice"></i> Lihat Struk Pesanan
        </a>
    </div>
</div>

</body>
</html>
