<?php 
// Mengimpor file datadummy.php yang berisi data gedung
require "datadummy.php"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gedung Lima Rasa</title>
    <!-- Mengimpor CSS Bootstrap untuk tampilan yang lebih baik -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Gedung Lima Rasa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Bagian Selamat Datang -->
    <section class="text-center py-5">
        <div class="container">
            <h1 class="fw-bold">Selamat Datang di Gedung Lima Rasa</h1>
            <p class="lead">Kami menyediakan berbagai macam jenis gedung seperti VIP, Ballroom, dan Outdoor.</p>
            <!-- Tombol Pesan Sekarang -->
            <div class="text-center py-4">
                <a href="form_transaksi.php" class="btn btn-primary btn-lg">Pesan Sekarang</a>
            </div>
            <img src="img/logo.png" alt="logo" class="py-4">
        </div>
    </section>

    <!-- Bagian Produk -->
    <section id="produk" class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Jenis Gedung Yang Tersedia</h2>
            <div class="row">
                <?php foreach ($gedung as $g) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 d-flex flex-column">
                            <!-- Menampilkan gambar gedung -->
                            <img src="img/<?= $g['gambar']; ?>" class="card-img-top" alt="<?= $g['nama']; ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"> <?= $g['nama']; ?> </h5>
                                <p class="card-text"> <?= $g['deskripsi']; ?> </p>
                                <p class="fw-bold text-primary mt-auto">Rp <?= number_format($g['harga'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Bagian Tentang Kami -->
    <section id="tentang" class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="fw-bold mb-4">Tentang Kami</h2>
            <p>Gedung Lima Rasa menyediakan layanan sewa gedung yang nyaman dan mewah dengan harga terbaik.</p>
            <ul class="list-unstyled">
                <li>Alamat: Jl. A.Yani KM 5 No. 112, Banjarmasin</li>
                <li>Telepon: +62 21 1234 5678</li>
                <li>Email: gedunglimarasa@gmail.com</li>
            </ul>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 Gedung Lima Rasa. All Rights Reserved.</p>
    </footer>
    
    <!-- Mengimpor JavaScript Bootstrap untuk interaktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
