<?php
session_start();
include 'koneksi/koneksi.php';
include 'header.php';

$kd = mysqli_real_escape_string($conn, $_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container" style="padding-bottom: 200px">
    <h2 style="border-bottom: 4px solid #335C67"><b>Checkout</b></h2>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Daftar Pesanan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4>Daftar Pesanan</h4>
            <table class="table table-bordered">
                <tr><th>No</th><th>Nama</th><th>Harga</th><th>Qty</th><th>Sub Total</th></tr>
                <?php 
                $result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
                $no = 1; $hasil = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $subtotal = $row['harga'] * $row['qty'];
                    $hasil += $subtotal;
                    echo "<tr>
                        <td>$no</td>
                        <td>{$row['nama_produk']}</td>
                        <td>Rp. ".number_format($row['harga'])."</td>
                        <td>{$row['qty']}</td>
                        <td>Rp. ".number_format($subtotal)."</td>
                    </tr>";
                    $no++;
                } ?>
                <tr>
                    <td colspan="5" class="text-right font-weight-bold">Grand Total = Rp.<?= number_format($hasil); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Form Checkout -->
    <form action="proses/order.php" method="POST">
        <input type="hidden" name="kode_cs" value="<?= $kd; ?>">
        <input type="hidden" name="grand_total" value="<?= $hasil; ?>">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" value="<?= $rows['nama']; ?>" readonly>
        </div>

        <!-- Maps dan Alamat -->
        <div class="form-group">
            <label>Alamat Otomatis via Peta</label>
            <input type="text" class="form-control mb-2" name="alamat" id="alamat" placeholder="Klik lokasi di peta">
            <div id="map" style="height: 300px;"></div>
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Kode Pos</label>
                <input type="text" class="form-control" name="kopos" required>
            </div>
            <div class="col-md-6">
                <label>Metode Pembayaran</label>
                <select name="metode" id="metode" class="form-control" required onchange="toggleUpload()">
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank (BCA 12345678 a/n Lokalista)</option>
                    <option value="E-Wallet">E-Wallet (QRIS / OVO / DANA)</option>
                    <option value="COD">COD (Bayar Ditempat)</option>
                </select>
            </div>
        </div>

        <!-- Tidak ditampilkan -->
        <input type="hidden" name="bukti" value="">

        <button type="submit" class="btn btn-success mt-3">Order Sekarang</button>
        <a href="keranjang.php" class="btn btn-danger mt-3">Cancel</a>
    </form>
</div>

<!-- Leaflet & Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([-6.200000, 106.816666], 13); // Default Jakarta
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

var marker = L.marker([-6.200000, 106.816666], {draggable: true}).addTo(map);

// Update koordinat dan alamat saat marker digeser
marker.on('dragend', function(e) {
    var latlng = marker.getLatLng();
    updateLocation(latlng.lat, latlng.lng);
});

// Update saat klik peta
map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    updateLocation(e.latlng.lat, e.latlng.lng);
});

function updateLocation(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('alamat').value = data.display_name || '';
        });
}

// Optional: Upload bukti hilang total
function toggleUpload() {
    document.getElementById("uploadBukti").style.display = "none";
}
</script>

<?php include 'footer.php'; ?>
