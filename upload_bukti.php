<?php
include 'koneksi/koneksi.php';
$kode_order = $_GET['order'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_file = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
    $new_name = 'bukti-' . time() . '.' . $ext;
    move_uploaded_file($tmp, 'bukti/' . $new_name);

    mysqli_query($conn, "UPDATE orders SET bukti = '$new_name', status_pembayaran = 'sudah_bayar' WHERE kode_order = '$kode_order'");
    $_SESSION['success'] = 'Pembayaran berhasil dikonfirmasi.';
    header("Location: struk.php?order=$kode_order");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Upload Bukti Pembayaran
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="bukti" class="form-label">Foto/Screenshot Bukti Transfer</label>
                    <input type="file" name="bukti" id="bukti" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Kirim</button>
                <a href="struk.php?order=<?= $kode_order; ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
