<?php 
include 'header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4 border-bottom pb-2" style="border-color: #335C67;"><b>Master Produk</b></h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM produk");
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['kode_produk']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td>
                        <img src="../image/produk/<?= $row['image']; ?>" class="img-thumbnail" width="80" height="80" alt="produk">
                    </td>
                    <td>Rp.<?= number_format($row['harga']); ?></td>
                    <td>
                        <a href="edit_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-sm btn-warning mb-1">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        <a href="proses/del_produk.php?kode=<?= $row['kode_produk']; ?>" 
                           class="btn btn-sm btn-danger mb-1"
                           onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            <i class="glyphicon glyphicon-trash"></i> Hapus
                        </a>
                        <a href="bom.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-sm btn-primary mb-1">
                            <i class="glyphicon glyphicon-eye-open"></i> Lihat BOM
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="text-right mt-3">
        <a href="tm_produk.php" class="btn btn-success">
            <i class="glyphicon glyphicon-plus-sign"></i> Tambah Produk
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
