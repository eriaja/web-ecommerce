<?php
include 'koneksi/koneksi.php';
$kode_order = $_GET['order'] ?? '';

$order = mysqli_query($conn, "SELECT * FROM orders WHERE kode_order = '$kode_order'");
$data = mysqli_fetch_assoc($order);
$items = mysqli_query($conn, "SELECT * FROM order_detail WHERE kode_order = '$kode_order'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran - Lokalista</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --shopee-orange: #ee4d2d;
            --shopee-light-orange: #ff6b35;
            --shopee-dark-orange: #d73502;
            --shopee-bg: #f5f5f5;
            --shopee-white: #ffffff;
            --shopee-gray: #757575;
            --shopee-light-gray: #f8f9fa;
            --shopee-border: #e5e5e5;
            --shopee-success: #00b894;
            --shopee-warning: #fdcb6e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--shopee-bg);
            color: #333;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--shopee-orange), var(--shopee-light-orange));
            box-shadow: 0 2px 10px rgba(238, 77, 45, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar a {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            color: var(--shopee-warning) !important;
            transform: translateY(-2px);
        }

        .container-main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .payment-header {
            background: var(--shopee-white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid var(--shopee-orange);
        }

        .payment-header h2 {
            color: var(--shopee-orange);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .order-summary {
            background: var(--shopee-white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .order-summary h4 {
            color: var(--shopee-orange);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .order-summary h4 i {
            margin-right: 0.5rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--shopee-border);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .item-details {
            color: var(--shopee-gray);
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: 600;
            color: var(--shopee-orange);
        }

        .total-section {
            background: linear-gradient(135deg, var(--shopee-orange), var(--shopee-light-orange));
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1rem;
            text-align: center;
        }

        .total-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .payment-methods {
            background: var(--shopee-white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .payment-methods h4 {
            color: var(--shopee-orange);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .payment-methods h4 i {
            margin-right: 0.5rem;
        }

        .payment-option {
            border: 2px solid var(--shopee-border);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-option:hover {
            border-color: var(--shopee-orange);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(238, 77, 45, 0.1);
        }

        .payment-option.selected {
            border-color: var(--shopee-orange);
            background: linear-gradient(135deg, rgba(238, 77, 45, 0.1), rgba(255, 107, 53, 0.1));
        }

        .payment-option.selected::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 15px;
            color: var(--shopee-orange);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .payment-method-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .ewallet-icon { background: linear-gradient(135deg, #00b894, #00a085); }
        .bank-icon { background: linear-gradient(135deg, #0984e3, #0670d3); }
        .cod-icon { background: linear-gradient(135deg, #fdcb6e, #e17055); }

        .payment-method-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .payment-method-desc {
            color: var(--shopee-gray);
            font-size: 0.9rem;
        }

        .ewallet-options {
            display: none;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--shopee-border);
        }

        .ewallet-option {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--shopee-border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ewallet-option:hover {
            border-color: var(--shopee-orange);
            background: rgba(238, 77, 45, 0.05);
        }

        .ewallet-option.selected {
            border-color: var(--shopee-orange);
            background: rgba(238, 77, 45, 0.1);
        }

        .ewallet-logo {
            width: 32px;
            height: 32px;
            margin-right: 0.75rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 0.8rem;
        }

        .gopay-logo { background: #00aa13; }
        .dana-logo { background: #118ee9; }
        .ovo-logo { background: #4c3494; }
        .shopeepay-logo { background: var(--shopee-orange); }
        .linkaja-logo { background: #e31e24; }

        .qr-payment {
            display: none;
            text-align: center;
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: var(--shopee-light-gray);
            border-radius: 12px;
        }

        .qr-code {
            width: 200px;
            height: 200px;
            background: white;
            border: 2px solid var(--shopee-border);
            border-radius: 12px;
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--shopee-gray);
        }

        .bank-info {
            display: none;
            margin-top: 1rem;
            padding: 1.5rem;
            background: var(--shopee-light-gray);
            border-radius: 12px;
        }

        .bank-account {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid var(--shopee-border);
        }

        .bank-details {
            flex: 1;
        }

        .bank-name {
            font-weight: 600;
            color: #333;
        }

        .account-number {
            color: var(--shopee-orange);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .copy-btn {
            background: var(--shopee-orange);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: var(--shopee-dark-orange);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--shopee-orange), var(--shopee-light-orange));
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(238, 77, 45, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--shopee-orange);
            border: 2px solid var(--shopee-orange);
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
        }

        .btn-secondary:hover {
            background: var(--shopee-orange);
            color: white;
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-paid { background: #d4edda; color: #155724; }
        .badge-cod { background: #cce5ff; color: #004085; }

        .footer {
            background: linear-gradient(135deg, var(--shopee-orange), var(--shopee-light-orange));
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        .upload-section {
            display: none;
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: var(--shopee-light-gray);
            border-radius: 12px;
        }

        .upload-area {
            border: 2px dashed var(--shopee-orange);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            background: rgba(238, 77, 45, 0.05);
        }

        .upload-area i {
            font-size: 3rem;
            color: var(--shopee-orange);
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .container-main {
                padding: 0 0.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .order-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .item-price {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fas fa-store"></i> Lokalista</a>

    <!-- Tombol hamburger saat tampilan mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu navbar -->
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a>
        </li>
        <li class="nav-item">
         
        </li>
      </ul>
    </div>
  </div>
</nav>



<div class="container-main">
    <!-- PAYMENT HEADER -->
    <div class="payment-header">
        <h2><i class="fas fa-credit-card"></i> Pembayaran</h2>
        <p class="mb-0">Kode Pesanan: <strong>ORD-2024-001</strong></p>
    </div>

    <div class="row">
        <!-- ORDER SUMMARY -->
        <div class="order-summary">
    <h4><i class="fas fa-receipt"></i> Ringkasan Pesanan</h4>

    <?php
    $items = mysqli_query($conn, "SELECT * FROM order_detail WHERE kode_order = '$kode_order'");
    $grandTotal = 0;

    while ($item = mysqli_fetch_assoc($items)) {
        $subtotal = $item['harga'] * $item['qty'];
        $grandTotal += $subtotal;
        echo '
        <div class="order-item">
            <div class="item-info">
                <div class="item-name">'.htmlspecialchars($item['nama_produk']).'</div>
                <div class="item-details">Qty: '.$item['qty'].' x Rp '.number_format($item['harga']).'</div>
            </div>
            <div class="item-price">Rp '.number_format($subtotal).'</div>
        </div>';
    }
    ?>

    <div class="total-section">
        <h3>Total: Rp <?= number_format($grandTotal) ?></h3>
    </div>
</div>


        <!-- PAYMENT METHODS -->
        <div class="col-lg-7">
            <div class="payment-methods">
                <h4><i class="fas fa-wallet"></i> Pilih Metode Pembayaran</h4>

                <!-- E-WALLET -->
                <div class="payment-option" onclick="selectPayment('ewallet')">
                    <div class="payment-method-header">
                        <div class="payment-icon ewallet-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <div class="payment-method-title">E-Wallet</div>
                            <div class="payment-method-desc">Bayar dengan GoPay, DANA, OVO, dan lainnya</div>
                        </div>
                    </div>
                    <div class="ewallet-options" id="ewallet-options">
                        <div class="ewallet-option" onclick="selectEwallet('gopay', event)">
                            <div class="ewallet-logo gopay-logo">GP</div>
                            <span>GoPay</span>
                        </div>
                        <div class="ewallet-option" onclick="selectEwallet('dana', event)">
                            <div class="ewallet-logo dana-logo">DANA</div>
                            <span>DANA</span>
                        </div>
                        <div class="ewallet-option" onclick="selectEwallet('ovo', event)">
                            <div class="ewallet-logo ovo-logo">OVO</div>
                            <span>OVO</span>
                        </div>
                        <div class="ewallet-option" onclick="selectEwallet('shopeepay', event)">
                            <div class="ewallet-logo shopeepay-logo">SP</div>
                            <span>ShopeePay</span>
                        </div>
                        <div class="ewallet-option" onclick="selectEwallet('linkaja', event)">
                            <div class="ewallet-logo linkaja-logo">LA</div>
                            <span>LinkAja</span>
                        </div>
                    </div>
                </div>

                <!-- QR CODE PAYMENT -->
                <div class="qr-payment" id="qr-payment">
                    <h5>Scan QR Code untuk Pembayaran</h5>
                    <div class="qr-code">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <p class="text-muted">Scan menggunakan aplikasi <span id="selected-ewallet">E-Wallet</span></p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Pembayaran akan otomatis terverifikasi setelah berhasil
                    </div>
                </div>

                <!-- BANK TRANSFER -->
                <div class="payment-option" onclick="selectPayment('bank')">
                    <div class="payment-method-header">
                        <div class="payment-icon bank-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div>
                            <div class="payment-method-title">Transfer Bank</div>
                            <div class="payment-method-desc">Transfer melalui ATM, Mobile Banking, atau Internet Banking</div>
                        </div>
                    </div>
                </div>

                <!-- BANK INFO -->
                <div class="bank-info" id="bank-info">
                    <h5>Transfer ke Rekening Berikut:</h5>
                    <div class="bank-account">
                        <div class="bank-details">
                            <div class="bank-name">Bank BCA</div>
                            <div class="account-number">1234567890</div>
                            <div class="text-muted">a.n. Lokalista Indonesia</div>
                        </div>
                        <button class="copy-btn" onclick="copyToClipboard('1234567890')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    <div class="bank-account">
                        <div class="bank-details">
                            <div class="bank-name">Bank Mandiri</div>
                            <div class="account-number">0987654321</div>
                            <div class="text-muted">a.n. Lokalista Indonesia</div>
                        </div>
                        <button class="copy-btn" onclick="copyToClipboard('0987654321')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Transfer sesuai dengan nominal yang tertera. Pembayaran akan diverifikasi dalam 1x24 jam.
                    </div>
                </div>

                <!-- COD -->
                <div class="payment-option" onclick="selectPayment('cod')">
                    <div class="payment-method-header">
                        <div class="payment-icon cod-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div>
                            <div class="payment-method-title">Bayar di Tempat (COD)</div>
                            <div class="payment-method-desc">Bayar langsung saat barang tiba</div>
                        </div>
                    </div>
                </div>

                <!-- UPLOAD BUKTI -->
                <div class="upload-section" id="upload-section">
                    <h5>Upload Bukti Pembayaran</h5>
                    <div class="upload-area" onclick="document.getElementById('bukti-file').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h6>Klik untuk upload bukti transfer</h6>
                        <p class="text-muted">Foto atau screenshot bukti pembayaran (JPG, PNG, PDF)</p>
                        <input type="file" id="bukti-file" accept="image/*,application/pdf" style="display: none;" onchange="handleFileUpload(event)">
                    </div>
                    <div id="uploaded-file" style="display: none;">
                        <div class="alert alert-success">
                            <i class="fas fa-check"></i> File berhasil dipilih: <span id="file-name"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="action-buttons">
                <button class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <button class="btn btn-primary" onclick="processPayment()">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    <p>&copy; 2024 Lokalista - Bangga Produk Lokal Indonesia</p>
    <p>Pembayaran Aman & Terpercaya</p>
</div>

<script>
let selectedPayment = '';
let selectedEwallet = '';

function selectPayment(method) {
    // Reset all selections
    document.querySelectorAll('.payment-option').forEach(el => {
        el.classList.remove('selected');
    });
    
    // Hide all payment details
    document.getElementById('ewallet-options').style.display = 'none';
    document.getElementById('qr-payment').style.display = 'none';
    document.getElementById('bank-info').style.display = 'none';
    document.getElementById('upload-section').style.display = 'none';
    
    // Select current payment method
    event.currentTarget.classList.add('selected');
    selectedPayment = method;
    
    if (method === 'ewallet') {
        document.getElementById('ewallet-options').style.display = 'block';
    } else if (method === 'bank') {
        document.getElementById('bank-info').style.display = 'block';
        document.getElementById('upload-section').style.display = 'block';
    }
}

function selectEwallet(wallet, event) {
    event.stopPropagation();
    
    // Reset ewallet selections
    document.querySelectorAll('.ewallet-option').forEach(el => {
        el.classList.remove('selected');
    });
    
    // Select current ewallet
    event.currentTarget.classList.add('selected');
    selectedEwallet = wallet;
    
    // Show QR code
    document.getElementById('qr-payment').style.display = 'block';
    document.getElementById('selected-ewallet').textContent = getEwalletName(wallet);
}

function getEwalletName(wallet) {
    const names = {
        'gopay': 'GoPay',
        'dana': 'DANA',
        'ovo': 'OVO',
        'shopeepay': 'ShopeePay',
        'linkaja': 'LinkAja'
    };
    return names[wallet] || 'E-Wallet';
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
        btn.style.background = 'var(--shopee-success)';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = 'var(--shopee-orange)';
        }, 2000);
    });
}

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('uploaded-file').style.display = 'block';
    }
}

function processPayment() {
    if (!selectedPayment) {
        alert('Silakan pilih metode pembayaran terlebih dahulu');
        return;
    }
    
    if (selectedPayment === 'ewallet' && !selectedEwallet) {
        alert('Silakan pilih jenis e-wallet terlebih dahulu');
        return;
    }
    
    if (selectedPayment === 'bank') {
        // Check if proof is uploaded
        const fileInput = document.getElementById('bukti-file');
        if (!fileInput.files.length) {
            alert('Silakan upload bukti pembayaran terlebih dahulu');
            return;
        }
    }
    
    // Simulate payment processing
    const btn = document.querySelector('.btn-primary');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;
    
    setTimeout(() => {
        if (selectedPayment === 'cod') {
            alert('Pesanan berhasil dibuat! Silakan siapkan uang pas saat barang tiba.');
        } else if (selectedPayment === 'ewallet') {
            alert('Menunggu pembayaran melalui ' + getEwalletName(selectedEwallet));
        } else {
            alert('Bukti pembayaran berhasil diupload! Pembayaran akan diverifikasi dalam 1x24 jam.');
        }
        
        // Redirect to success page
        window.location.href = 'struk.php?order=ORD-2024-001';
    }, 3000);
}

// Animation on scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(238, 77, 45, 0.3)';
    } else {
        navbar.style.boxShadow = '0 2px 10px rgba(238, 77, 45, 0.2)';
    }
});
</script>

</body>
</html>