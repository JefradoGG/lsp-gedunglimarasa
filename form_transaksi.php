<?php
// Memasukkan file "datadummy.php" yang berisi data gedung
require "datadummy.php";

// Memulai session untuk menyimpan data transaksi
session_start();

// Jika tidak ada data transaksi di dalam session, buat array kosong
$_SESSION['transaksi'] = $_SESSION['transaksi'] ?? [];

// Inisialisasi variabel untuk menyimpan pesan kesalahan dan total pembayaran
$errors = [];
$total = 0;

// Jika tipe gedung belum dipilih, default ke tipe pertama dalam array gedung
if (!isset($_POST['tipeGedung']) && isset($gedung[0]['nama'])) {
    $selectedID = $gedung[0]['nama']; // Pilih tipe pertama (VIP)
} else {
    $selectedID = $_POST['tipeGedung'] ?? '';
}

// Ambil harga berdasarkan tipe gedung yang dipilih
$hargaGedung = array_column($gedung, 'harga', 'nama')[$selectedID] ?? 0;

// Mengecek apakah ada request POST (saat form dikirimkan)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Mengambil data dari form dan menyimpannya dalam array $data
    $data = [
        'nama' => $_POST['nama'] ?? '', // Nama penyewa
        'jenisKelamin' => $_POST['jenisKelamin'] ?? '', // Jenis kelamin penyewa
        'identitas' => $_POST['identitas'] ?? '', // Nomor identitas penyewa (misalnya KTP)
        'tipeGedung' => $selectedID, // Tipe gedung yang dipilih
        'tanggalPesan' => $_POST['tanggalPesan'] ?? '', // Tanggal pemesanan
        'durasi' => $_POST['durasi'] ?? 0, // Durasi penyewaan dalam hari
        'catering' => isset($_POST['catering']) ? 1200000 : 0 // Harga catering jika dipilih (1.200.000 per hari)
    ];
    
    // Validasi input durasi, harus lebih dari 0 dan angka
    if (!is_numeric($data['durasi']) || $data['durasi'] <= 0) {
        $errors[] = "Durasi harus lebih dari 0";
    }
    
    // Validasi nomor identitas, harus terdiri dari 16 digit angka
    if (!is_numeric($data['identitas']) || strlen($data['identitas']) !== 16) {
        $errors[] = "Nomor Identitas harus 16 digit angka";
    }
    
    // Jika tidak ada error, hitung total harga
    if (!$errors) {
        // Menghitung total biaya berdasarkan durasi dan pilihan catering
        $total = ($hargaGedung * $data['durasi']) + ($data['catering'] * $data['durasi']);
        
        // Jika durasi sewa 3 hari atau lebih, berikan diskon 10%
        if ($data['durasi'] >= 3) {
            $total *= 0.9;
        }
    }

    // Jika tombol "simpan" ditekan dan tidak ada error
    if (isset($_POST['simpan']) && !$errors) {
        // Menyimpan transaksi ke dalam session, termasuk total bayar yang sudah diformat
        $_SESSION['transaksi'][] = array_merge($data, ['totalBayar' => number_format($total, 0, ',', '.')]);

        // Menampilkan alert JavaScript dengan detail transaksi, lalu kembali ke halaman utama
        echo "<script>
            alert('Pesanan Berhasil!\\n\\n" . 
                "Nama: {$data['nama']}\\n" . 
                "Nomor Identitas: {$data['identitas']}\\n" . 
                "Jenis Kelamin: {$data['jenisKelamin']}\\n" . 
                "Jenis Gedung: {$data['tipeGedung']}\\n" . 
                "Catering: " . ($data['catering'] ? 'Ya' : 'Tidak') . "\\n" . 
                "Durasi: {$data['durasi']} hari\\n" . 
                "Diskon: " . ($data['durasi'] >= 3 ? '10%' : '0%') . "\\n" . 
                "Total Bayar: Rp " . number_format($total, 0, ',', '.') . "');
            window.location.href = 'index.php';
        </script>";
        exit(); // Menghentikan eksekusi script setelah redirect
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pemesanan Gedung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Form Pemesanan Gedung</h2>
        <div class="card">
            <div class="card-body">
                <?php if ($errors) { ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) { echo "<li>$error</li>"; } ?>
                        </ul>
                    </div>
                <?php } ?>
                <form method="POST">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama Pemesan" value="<?= $_POST['nama'] ?? '' ?>" required>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label><br>
                        <input class="form-check-input" type="radio" name="jenisKelamin" value="Laki-laki" <?= ($_POST['jenisKelamin'] ?? '') === 'Laki-laki' ? 'checked' : '' ?>> Laki-laki
                        <input class="form-check-input ms-3" type="radio" name="jenisKelamin" value="Perempuan" <?= ($_POST['jenisKelamin'] ?? '') === 'Perempuan' ? 'checked' : '' ?>> Perempuan
                    </div>
                    <input type="text" class="form-control mb-3" name="identitas" placeholder="Nomor Identitas (16 digit)" value="<?= $_POST['identitas'] ?? '' ?>" required>
                    <select class="form-select mb-3" name="tipeGedung" onchange="this.form.submit()">
                        <?php foreach ($gedung as $g) { ?>
                            <option value="<?= $g['nama'] ?>" <?= ($selectedID == $g['nama']) ? 'selected' : '' ?>>
                                <?= $g['nama'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="text" class="form-control mb-3" value="<?= 'Rp ' . number_format($hargaGedung, 0, ',', '.') ?>" readonly>
                    <input type="date" class="form-control mb-3" name="tanggalPesan" value="<?= $_POST['tanggalPesan'] ?? '' ?>" required>
                    <input type="number" class="form-control mb-3" name="durasi" placeholder="Durasi Sewa (hari)" value="<?= $_POST['durasi'] ?? '' ?>" required>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="catering" value="1200000" <?= isset($_POST['catering']) ? 'checked' : '' ?>> Termasuk Catering (Rp 1.200.000/hari)
                    </div>
                    <input type="text" class="form-control mb-3" value="<?= $total ? number_format($total, 0, ',', '.') : '' ?>" placeholder="Total Bayar" readonly>
                    <button type="submit" name="hitung" class="btn btn-primary">Hitung Total</button>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
