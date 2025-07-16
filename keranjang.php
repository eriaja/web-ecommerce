<?php 
session_start();
include 'koneksi/koneksi.php';
include 'header.php';

// Cek apakah user sudah login
if (!isset($_SESSION['kd_cs'])) {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger text-center'>
                <h5><b>Silakan login terlebih dahulu sebelum berbelanja</b></h5>
            </div>
          </div>";
    include 'footer.php';
    exit;
}

$kode_cs = $_SESSION['kd_cs'];

// Update qty
if (isset($_POST['submit1'])) {
    $id_keranjang = $_POST['id'];
    $qty = $_POST['qty'];

    $edit = mysqli_query($conn, "UPDATE keranjang SET qty = '$qty' WHERE id_keranjang = '$id_keranjang'");
    if ($edit) {
        echo "<script>alert('Keranjang berhasil diperbarui'); window.location='keranjang.php';</script>";
        exit;
    }
}

// Hapus produk
if (isset($_GET['del'])) {
    $id_keranjang = $_GET['id'];
    $del = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");
    if ($del) {
        echo "<script>alert('1 produk dihapus'); window.location='keranjang.php';</script>";
        exit;
    }
}
?>

<style>
.cart-container {
    background-color: #f5f5f5;
    min-height: 100vh;
    padding: 20px 0;
}

.cart-header {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.cart-header h2 {
    color: #ee4d2d;
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.cart-item {
    background: white;
    border-radius: 8px;
    margin-bottom: 15px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.cart-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.product-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #f0f0f0;
}

.product-info {
    flex: 1;
    padding-left: 15px;
}

.product-name {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 5px;
    line-height: 1.4;
}

.product-price {
    color: #ee4d2d;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.qty-btn:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.qty-input {
    width: 60px;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 5px;
    font-size: 14px;
}

.subtotal {
    color: #ee4d2d;
    font-size: 18px;
    font-weight: 600;
    margin-left: 20px;
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn-update {
    background: #ffa726;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.btn-update:hover {
    background: #ff9800;
}

.btn-delete {
    background: #f44336;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s ease;
}

.btn-delete:hover {
    background: #d32f2f;
    color: white;
}

.cart-summary {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
}

.total-section {
    border-top: 2px solid #f0f0f0;
    padding-top: 20px;
    margin-top: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.total-label {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.total-amount {
    font-size: 24px;
    font-weight: 700;
    color: #ee4d2d;
}

.checkout-section {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.btn-continue {
    background: #4caf50;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s ease;
    flex: 1;
}

.btn-continue:hover {
    background: #45a049;
    color: white;
}

.btn-checkout {
    background: #ee4d2d;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s ease;
    flex: 1;
}

.btn-checkout:hover {
    background: #d73502;
    color: white;
}

.empty-cart {
    background: white;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.empty-cart-icon {
    font-size: 80px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-cart-text {
    color: #666;
    font-size: 18px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .cart-item {
        padding: 15px;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
    }
    
    .product-name {
        font-size: 14px;
    }
    
    .product-price, .subtotal {
        font-size: 16px;
    }
    
    .checkout-section {
        flex-direction: column;
    }
}
</style>

<div class="cart-container">
    <div class="container">
        <div class="cart-header">
            <h2><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
        </div>

        <?php 
        $result = mysqli_query($conn, "SELECT k.id_keranjang, k.kode_produk, k.nama_produk, k.qty, p.image, p.harga 
                                        FROM keranjang k 
                                        JOIN produk p ON k.kode_produk = p.kode_produk 
                                        WHERE k.kode_customer = '$kode_cs'");
        $no = 1;
        $total = 0;
        
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='row'>";
            echo "<div class='col-lg-8'>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                $subtotal = $row['qty'] * $row['harga'];
                $total += $subtotal;
        ?>
                <div class="cart-item">
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id_keranjang']; ?>">
                        <div class="d-flex align-items-center">
                            <img src="image/produk/<?= $row['image']; ?>" class="product-image" alt="<?= $row['nama_produk']; ?>">
                            
                            <div class="product-info">
                                <div class="product-name"><?= $row['nama_produk']; ?></div>
                                <div class="product-price">Rp. <?= number_format($row['harga']); ?></div>
                                
                                <div class="quantity-controls">
                                    <span>Qty:</span>
                                    <input type="number" name="qty" class="qty-input" min="1" value="<?= $row['qty']; ?>">
                                </div>
                                
                                <div class="action-buttons">
                                    <button type="submit" name="submit1" class="btn-update">
                                        <i class="fas fa-sync"></i> Update
                                    </button>
                                    <a href="keranjang.php?del=1&id=<?= $row['id_keranjang']; ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                            
                            <div class="subtotal">
                                Rp. <?= number_format($subtotal); ?>
                            </div>
                        </div>
                    </form>
                </div>
        <?php 
            }
            
            echo "</div>";
            echo "<div class='col-lg-4'>";
            echo "<div class='cart-summary'>";
            echo "<h5><i class='fas fa-receipt'></i> Ringkasan Belanja</h5>";
            echo "<div class='total-section'>";
            echo "<div class='total-row'>";
            echo "<span class='total-label'>Total Pembayaran:</span>";
            echo "<span class='total-amount'>Rp. " . number_format($total) . "</span>";
            echo "</div>";
            echo "<div class='checkout-section'>";
            echo "<a href='index.php' class='btn-continue'><i class='fas fa-arrow-left'></i> Lanjut Belanja</a>";
            echo "<a href='checkout.php?kode_cs=" . $kode_cs . "' class='btn-checkout'><i class='fas fa-credit-card'></i> Checkout</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='empty-cart'>";
            echo "<div class='empty-cart-icon'><i class='fas fa-shopping-cart'></i></div>";
            echo "<div class='empty-cart-text'>Keranjang belanja Anda kosong</div>";
            echo "<a href='index.php' class='btn-continue'><i class='fas fa-store'></i> Mulai Belanja</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php 
include 'footer.php';
?>