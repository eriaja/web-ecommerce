<?php 
session_start();
include 'koneksi/koneksi.php';
include 'header.php';

// Ambil ID produk
$kode = mysqli_real_escape_string($conn, $_GET['produk'] ?? '');

// Ambil info produk
$result = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk = '$kode'");
$row = mysqli_fetch_assoc($result);

// Jika produk tidak ditemukan
if (!$row) {
    echo "<script>alert('Produk tidak ditemukan'); window.location='produk.php';</script>";
    exit;
}

// Ambil kode customer dari session (jika login)
$kode_cs = $_SESSION['kd_cs'] ?? null;
?>
<div class="container" style="padding-bottom: 250px;">
	<h2 style="border-bottom: 4px solid #335C67"><b>Detail Produk</b></h2>

	<div class="row mt-4">
		<div class="col-md-4">
			<img src="image/produk/<?= $row['image']; ?>" alt="<?= $row['nama']; ?>" class="img-fluid rounded">
		</div>

		<div class="col-md-8">
			<form action="proses/add.php" method="GET">
				<input type="hidden" name="produk" value="<?= $kode; ?>">
				<input type="hidden" name="hal" value="2">
				<?php if ($kode_cs): ?>
					<input type="hidden" name="kd_cs" value="<?= $kode_cs; ?>">
				<?php endif; ?>
				
				<table class="table">
					<tr>
						<td><strong>Nama</strong></td>
						<td><?= $row['nama']; ?></td>
					</tr>
					<tr>
						<td><strong>Harga</strong></td>
						<td>Rp. <?= number_format($row['harga']); ?></td>
					</tr>
					<tr>
						<td><strong>Deskripsi</strong></td>
						<td><?= $row['deskripsi']; ?></td>
					</tr>
					<tr>
						<td><strong>Jumlah</strong></td>
						<td><input type="number" name="jml" min="1" value="1" class="form-control" style="width: 150px;"></td>
					</tr>
				</table>

				<?php if ($kode_cs): ?>
					<button type="submit" class="btn btn-success"><i class="fa fa-cart-plus"></i> Tambahkan ke Keranjang</button>
				<?php else: ?>
					<a href="user_login.php" class="btn btn-warning">Login untuk belanja</a>
				<?php endif; ?>
				<a href="index.php" class="btn btn-secondary">Kembali Belanja</a>
			</form>
		</div>
	</div>
</div>

<?php 
include 'footer.php';
?>
