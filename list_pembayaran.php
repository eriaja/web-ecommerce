<?php 
include 'header.php';
include '../koneksi/koneksi.php';

// Ambil semua data order
$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>

<div class="container mt-5 mb-5">
    <h3 class="mb-4" style="border-bottom: 3px solid #335C67; padding-bottom: 10px;">
        <i class="fas fa-receipt"></i> <b>Daftar Bukti Pembayaran</b>
    </h3>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead style="background-color: #335C67; color: white;">
                <tr>
                    <th>No</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="badge bg-dark text-white"><?= $row['kode_order']; ?></span></td>
                    <td><?= htmlspecialchars($row['nama_customer']); ?></td>
                    <td><strong>Rp.<?= number_format($row['total']); ?></strong></td>
                    <td>
                        <?php 
                        $metode = $row['metode_pembayaran'];
                        if ($metode == "COD") {
                            echo "<span class='badge bg-info text-dark'>COD</span>";
                        } elseif ($metode == "Transfer Bank") {
                            echo "<span class='badge bg-primary'>Transfer Bank</span>";
                        } elseif ($metode == "E-Wallet") {
                            echo "<span class='badge bg-success'>E-Wallet</span>";
                        } else {
                            echo "<span class='badge bg-secondary'>-</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if (!empty($row['bukti_transfer'])) {
                            echo "<span class='badge bg-success'>Sudah Bayar</span>";
                        } elseif ($metode == "COD") {
                            echo "<span class='badge bg-warning text-dark'>Bayar di Tempat</span>";
                        } else {
                            echo "<span class='badge bg-danger'>Belum Bayar</span>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (!empty($row['bukti_transfer'])): ?>
                            <a href="../<?= $row['bukti_transfer']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="detail_order.php?order=<?= $row['kode_order']; ?>" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
