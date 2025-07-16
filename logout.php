<?php
session_start();         // Mulai session
session_unset();         // Hapus semua variabel session
session_destroy();       // Hapus session sepenuhnya

// Arahkan kembali ke halaman login
header("Location: index.php");
exit;
?>
