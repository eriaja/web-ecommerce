<?php 
include 'header.php';

// Hapus data customer jika parameter tersedia
if (isset($_GET['page']) && $_GET['page'] === 'del' && isset($_GET['kode'])) {
    $kode = mysqli_real_escape_string($conn, $_GET['kode']);
    $result = mysqli_query($conn, "DELETE FROM customer WHERE kode_customer = '$kode'");

    if ($result) {
        echo "<script>
                alert('DATA CUSTOMER BERHASIL DIHAPUS');
                window.location = 'm_customer.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>

<div class="container mt-4 mb-5">
    <h2 style="border-bottom: 4px solid #335C67; padding-bottom: 10px;"><b>Data Customer</b></h2>
    
    <table class="table table-striped table-hover mt-3">
        <thead style="background-color: #335C67; color: white;">
            <tr class="text-center">
                <th>No</th>
                <th>Kode Customer</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center align-middle">
            <?php 
            $result = mysqli_query($conn, "SELECT * FROM customer ORDER BY kode_customer ASC");
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_customer']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td>
                    <a href="m_customer.php?kode=<?= $row['kode_customer']; ?>&page=del" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin ingin menghapus data customer ini?')">
                       <i class="glyphicon glyphicon-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
