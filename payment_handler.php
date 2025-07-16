<?php
// payment_handler.php
include 'koneksi/koneksi.php';

if ($_POST) {
    $kode_order = $_POST['kode_order'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $sub_metode = $_POST['sub_metode'] ?? ''; // untuk ewallet type
    
    // Handle file upload untuk bukti pembayaran
    $bukti_file = '';
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == 0) {
        $upload_dir = 'uploads/bukti/';
        $file_extension = pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION);
        $bukti_file = $kode_order . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $bukti_file;
        
        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $upload_path)) {
            // File uploaded successfully
        } else {
            die("Error uploading file");
        }
    }
    
    // Update order dengan metode pembayaran
    $status_pembayaran = 'belum_bayar';
    if ($metode_pembayaran == 'COD') {
        $status_pembayaran = 'cod';
    } elseif ($bukti_file) {
        $status_pembayaran = 'menunggu_verifikasi';
    }
    
    $update_query = "UPDATE orders SET 
                     metode_pembayaran = '$metode_pembayaran',
                     sub_metode = '$sub_metode',
                     status_pembayaran = '$status_pembayaran',
                     bukti_pembayaran = '$bukti_file',
                     updated_at = NOW()
                     WHERE kode_order = '$kode_order'";
    
    if (mysqli_query($conn, $update_query)) {
        // Send response based on payment method
        if ($metode_pembayaran == 'E-Wallet') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Menunggu pembayaran melalui ' . $sub_metode,
                'redirect' => 'payment_waiting.php?order=' . $kode_order
            ]);
        } elseif ($metode_pembayaran == 'Transfer Bank') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Bukti pembayaran berhasil diupload',
                'redirect' => 'payment_success.php?order=' . $kode_order
            ]);
        } elseif ($metode_pembayaran == 'COD') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pesanan berhasil dibuat dengan COD',
                'redirect' => 'order_success.php?order=' . $kode_order
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memproses pembayaran'
        ]);
    }
}

// Function untuk generate QR Code (menggunakan library qrcode)
function generateQRCode($kode_order, $amount, $ewallet_type) {
    // Implementasi QR Code generation
    // Bisa menggunakan library seperti phpqrcode atau API provider
    $qr_data = [
        'order_id' => $kode_order,
        'amount' => $amount,
        'method' => $ewallet_type,
        'timestamp' => time()
    ];
    
    // Return QR code image path atau base64
    return base64_encode(json_encode($qr_data));
}

// Function untuk check payment status (untuk ewallet)
function checkPaymentStatus($kode_order) {
    global $conn;
    
    $query = "SELECT * FROM orders WHERE kode_order = '$kode_order'";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);
    
    if ($order['metode_pembayaran'] == 'E-Wallet') {
        // Check dengan API payment gateway
        // Ini contoh implementasi, sesuaikan dengan provider yang digunakan
        $payment_status = checkEwalletPayment($order['kode_order'], $order['sub_metode']);
        
        if ($payment_status == 'paid') {
            // Update status pembayaran
            mysqli_query($conn, "UPDATE orders SET status_pembayaran = 'sudah_bayar' WHERE kode_order = '$kode_order'");
            return 'paid';
        }
    }
    
    return $order['status_pembayaran'];
}

// Webhook handler untuk notifikasi pembayaran dari payment gateway
function handlePaymentWebhook() {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if ($input && isset($input['order_id']) && isset($input['status'])) {
        $kode_order = $input['order_id'];
        $status = $input['status'];
        
        if ($status == 'paid') {
            global $conn;
            mysqli_query($conn, "UPDATE orders SET 
                               status_pembayaran = 'sudah_bayar',
                               paid_at = NOW() 
                               WHERE kode_order = '$kode_order'");
            
            // Send notification to customer
            sendPaymentNotification($kode_order);
        }
    }
}

function sendPaymentNotification($kode_order) {
    // Implementasi notifikasi (email, SMS, push notification, dll)
    // Contoh: kirim email konfirmasi pembayaran
}

// API endpoint untuk check payment status (AJAX)
if (isset($_GET['check_payment'])) {
    $kode_order = $_GET['order'];
    $status = checkPaymentStatus($kode_order);
    
    echo json_encode(['status' => $status]);
    exit;
}
?>
