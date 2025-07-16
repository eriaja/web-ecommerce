<?php 
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$order_id = $_GET['order'];

// Tandai sebagai dikonfirmasi (misalnya tambahkan status ke order)
mysqli_query($conn, "UPDATE orders SET status = 'Sudah Dibayar' WHERE kode_order = '$order_id'");

echo "<script>alert('Order berhasil dikonfirmasi'); window.location='list_pembayaran.php';</script>";
