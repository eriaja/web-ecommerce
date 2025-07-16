<?php 
session_start();
include 'koneksi/koneksi.php';

$success = '';
$error = '';

if (isset($_POST['send_message'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $subject = mysqli_real_escape_string($koneksi, $_POST['subject']);
    $message = mysqli_real_escape_string($koneksi, $_POST['message']);
    
    // Insert ke database (pastikan tabel messages sudah ada)
    $query = "INSERT INTO messages (nama, email, subject, message, tanggal) VALUES ('$nama', '$email', '$subject', '$message', NOW())";
    
    if (mysqli_query($koneksi, $query)) {
        $success = 'Pesan Anda berhasil dikirim! Kami akan membalas dalam 24 jam.';
    } else {
        $error = 'Gagal mengirim pesan. Silakan coba lagi.';
    }
}

if (isset($_SESSION['kd_cs'])) {
    $kode_cs = $_SESSION['kd_cs'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - Lokalista</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ee4d2d;
            --secondary-color: #f53d2d;
            --orange-light: #fff3e0;
            --text-dark: #333;
            --text-gray: #666;
            --border-color: #e5e5e5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 500;
            margin: 0;
        }

        .header .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .header .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .header .breadcrumb-item.active {
            color: white;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .help-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .help-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
        }

        .help-card h3 {
            color: var(--primary-color);
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .help-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .help-item:hover {
            background-color: #f8f9fa;
        }

        .help-item:last-child {
            border-bottom: none;
        }

        .help-icon {
            width: 40px;
            height: 40px;
            background: var(--orange-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .help-text {
            flex: 1;
        }

        .help-text h5 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .help-text p {
            font-size: 0.9rem;
            color: var(--text-gray);
            margin: 0;
        }

        .help-arrow {
            color: var(--text-gray);
            font-size: 1.2rem;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
        }

        .contact-form h3 {
            color: var(--text-dark);
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
        }

        /* Contact Methods */
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .contact-method {
            background: white;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            transition: transform 0.2s;
        }

        .contact-method:hover {
            transform: translateY(-2px);
        }

        .contact-method-icon {
            width: 60px;
            height: 60px;
            background: var(--orange-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .contact-method h4 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .contact-method p {
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .contact-method .contact-info {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .help-section {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .contact-methods {
                grid-template-columns: 1fr;
            }
            
            .main-content {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <h1><i class="fas fa-headset"></i> Pusat Bantuan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Pusat Bantuan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Help Sections -->
        <div class="help-section">
            <div class="help-card">
                <h3>Bantuan Pesanan</h3>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="help-text">
                        <h5>Lacak Pesanan</h5>
                        <p>Cek status pengiriman pesanan Anda</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="help-text">
                        <h5>Pengembalian & Penukaran</h5>
                        <p>Proses return dan tukar barang</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="help-text">
                        <h5>Pembayaran</h5>
                        <p>Bantuan terkait metode pembayaran</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>

            <div class="help-card">
                <h3>Bantuan Akun</h3>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="help-text">
                        <h5>Akun Saya</h5>
                        <p>Pengaturan profil dan keamanan akun</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="help-text">
                        <h5>Keamanan</h5>
                        <p>Ubah password dan verifikasi akun</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="help-text">
                        <h5>Notifikasi</h5>
                        <p>Atur preferensi notifikasi</p>
                    </div>
                    <div class="help-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Methods -->
        <div class="contact-methods">
            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h4>Live Chat</h4>
                <p>Respon cepat dalam hitungan menit</p>
                <div class="contact-info">Tersedia 24/7</div>
            </div>
            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h4>Telepon</h4>
                <p>Hubungi customer service kami</p>
                <div class="contact-info">+62 21 1234 5678</div>
            </div>
            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h4>Email</h4>
                <p>Kirim pertanyaan detail via email</p>
                <div class="contact-info">support@lokalista.com</div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <h3>Hubungi Kami</h3>
            <p style="color: var(--text-gray); margin-bottom: 25px;">
                Tidak menemukan jawaban yang Anda cari? Kirim pesan kepada kami dan kami akan membantu Anda.
            </p>
            
            <div id="alert-container"></div>
            
            <form id="contactForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori Pertanyaan</label>
                    <select class="form-control" id="kategori" required>
                        <option value="">Pilih kategori</option>
                        <option value="pesanan">Pesanan</option>
                        <option value="pembayaran">Pembayaran</option>
                        <option value="pengiriman">Pengiriman</option>
                        <option value="akun">Akun</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Subjek</label>
                    <input type="text" class="form-control" id="subjek" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pesan</label>
                    <textarea class="form-control" id="pesan" rows="5" required placeholder="Jelaskan masalah Anda secara detail..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const alertContainer = document.getElementById('alert-container');
            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const kategori = document.getElementById('kategori').value;
            const subjek = document.getElementById('subjek').value;
            const pesan = document.getElementById('pesan').value;
            
            // Simulate form submission
            setTimeout(() => {
                alertContainer.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        Pesan berhasil dikirim! Kami akan merespons dalam 24 jam ke email Anda.
                    </div>
                `;
                
                // Reset form
                this.reset();
                
                // Scroll to alert
                alertContainer.scrollIntoView({ behavior: 'smooth' });
            }, 1000);
        });

        // Help item click handlers
        document.querySelectorAll('.help-item').forEach(item => {
            item.addEventListener('click', function() {
                const title = this.querySelector('h5').textContent;
                alert(`Membuka bantuan untuk: ${title}`);
            });
        });
    </script>
</body>
</html>