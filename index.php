<?php
    $gedung = [
        ["VIP", 500000, "vip.jpeg"],
        ["Ballroom", 700000, "ballroom.jpg"],
        ["Outdoor", 400000, "outdoor.jpg"]
    ];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gedung Lima Rasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #4b6cb7, #182848);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link:hover {
            color: #b0c4de;
        }
        .welcome-section {
            text-align: center;
            padding: 50px 0;
        }
        .welcome-section img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }
        .product-card {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #182848, #4b6cb7);
            border: none;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 30px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4b6cb7, #182848);
        }
        footer {
            background: #182848;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gedung Lima Rasa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#produk">Jenis Gedung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="welcome-section">
            <h1 class="text-primary">Selamat Datang di Gedung Lima Rasa</h1>
            <img src="img/logo.png" alt="Selamat Datang">
        </div>
    </div>
    
    <div class="container mt-5">
        <section id="produk">
            <h2 class="text-center mb-4 text-primary">Jenis Gedung</h2>
            <div class="row">
                <?php foreach ($gedung as $g): ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="img/<?= $g[2]; ?>" alt="<?= $g[0]; ?>">
                            <h5 class="mt-3"><?= $g[0]; ?></h5>
                            <h5 class="text-success">Rp <?= number_format($g[1], 0, ',', '.'); ?></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    
    <div class="pesan-btn-container text-center mt-4">
        <a href="form_transaksi.php" class="btn btn-primary">Pesan Sekarang</a>
    </div>
    
    <div class="container mt-5">
        <section id="tentang">
            <div class="card text-center p-4">
                <h2 class="text-primary">Tentang Kami</h2>
                <p class="text-muted">Gedung Lima Rasa adalah tempat ideal untuk berbagai acara spesial Anda. Kami menawarkan gedung dengan fasilitas terbaik, harga terjangkau, dan layanan profesional.</p>
                <p><strong>📍 Alamat:</strong> Jalan Flamboyan III</p>
                <p><strong>📞 Telepon:</strong> <a href="tel:+62895383875089" class="text-decoration-none text-primary">+62895383875089</a></p>
                <p><strong>📧 Email:</strong> <a href="mailto:info@gedunglimarasa.com" class="text-decoration-none text-primary">info@gedunglimarasa.com</a></p>
                <div class="mt-3">
                    <h4 class="text-primary">Video Profil Kami</h4>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer class="text-center mt-5">
        <p class="mb-0">&copy; 2025 Gedung Lima Rasa. Semua Hak Cipta Dilindungi.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>