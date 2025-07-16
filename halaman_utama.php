<?php 
include 'header.php';
include '../koneksi/koneksi.php';

// Pesanan baru
$result1 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE terima = 0 AND tolak = 0");
$jml1 = mysqli_num_rows($result1);

// Pesanan dibatalkan
$result2 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE tolak = 1");
$jml2 = mysqli_num_rows($result2);

// Pesanan diterima
$result3 = mysqli_query($conn, "SELECT DISTINCT invoice FROM produksi WHERE terima = 1");
$jml3 = mysqli_num_rows($result3);
?>

<style>
    .dashboard-card {
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
        cursor: pointer;
        background: white;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .dashboard-title {
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .dashboard-number {
        font-size: 64px;
        font-weight: bold;
    }

    .dashboard-description {
        color: #555;
        font-size: 14px;
    }

    .btn-outline-primary {
        padding: 12px 30px;
        font-size: 18px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #335C67;
        color: #fff;
        border-color: #335C67;
    }

    body {
        background-color: #F7FAFC;
    }
</style>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-5" style="border-bottom: 4px solid #335C67; padding-bottom: 10px; color: #333;"><b>Dashboard Pesanan Produksi</b></h2>

    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="dashboard-card" style="border-left: 6px solid #3498db;">
                <div class="dashboard-title text-primary">Pesanan Baru</div>
                <div class="dashboard-number text-primary"><?= $jml1; ?></div>
                <div class="dashboard-description">Menunggu konfirmasi produksi</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card" style="border-left: 6px solid #e74c3c;">
                <div class="dashboard-title text-danger">Pesanan Dibatalkan</div>
                <div class="dashboard-number text-danger"><?= $jml2; ?></div>
                <div class="dashboard-description">Dibatalkan oleh sistem atau admin</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card" style="border-left: 6px solid #27ae60;">
                <div class="dashboard-title text-success">Pesanan Diterima</div>
                <div class="dashboard-number text-success"><?= $jml3; ?></div>
                <div class="dashboard-description">Telah selesai diproduksi</div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="list_pembayaran.php" class="btn btn-outline-primary btn-lg shadow-sm">
            📥 Lihat Bukti Pembayaran
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
