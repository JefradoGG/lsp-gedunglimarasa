<?php

// Memuat file yang berisi data gedung untuk digunakan dalam transaksi
require "datadummy.php";

// Memulai sesi PHP untuk menyimpan dan mengakses data transaksi
session_start();

// Jika tidak ada data transaksi yang tersimpan dalam sesi, buat array kosong
$_SESSION['transaksi'] = $_SESSION['transaksi'] ?? [];

// Membuat array kosong untuk menyimpan pesan kesalahan jika terjadi kesalahan input
$errors = [];

// Inisialisasi variabel total pembayaran dengan nilai awal 0
$total = 0;

// Menentukan tipe gedung yang dipilih berdasarkan input pengguna atau menggunakan tipe pertama secara default
$selectedID = $_POST['tipeGedung'] ?? $gedung[0]['nama'];

// Mengambil harga gedung berdasarkan tipe yang dipilih atau memberikan nilai 0 jika tidak ditemukan
$hargaGedung = array_column($gedung, 'harga', 'nama')[$selectedID] ?? 0;

// Memeriksa apakah formulir telah dikirim menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Mengambil input nama penyewa, jika kosong maka diisi string kosong
    $nama = $_POST['nama'] ?? '';
    
    // Mengambil input jenis kelamin penyewa
    $jenisKelamin = $_POST['jenisKelamin'] ?? '';
    
    // Mengambil input nomor identitas penyewa
    $identitas = $_POST['identitas'] ?? '';
    
    // Mengambil input tanggal pemesanan
    $tanggalPesan = $_POST['tanggalPesan'] ?? '';
    
    // Mengambil input durasi penyewaan dan jika tidak diisi, maka default ke 0
    $durasi = $_POST['durasi'] ?? 0;
    
    // Jika catering dipilih, biaya catering ditetapkan 1.200.000 per hari, jika tidak maka 0
    $catering = isset($_POST['catering']) ? 1200000 : 0;

    // Memvalidasi bahwa durasi harus berupa angka dan lebih dari 0
    if (!is_numeric($durasi) || $durasi <= 0) $errors[] = "Durasi harus lebih dari 0 dan harus angka";
    
    // Memvalidasi bahwa nomor identitas harus berupa angka dengan panjang 16 digit
    if (!is_numeric($identitas) || strlen($identitas) !== 16) $errors[] = "Nomor Identitas harus 16 digit angka";

    // Jika tidak ada error, lanjutkan perhitungan total pembayaran
    if (!$errors) {
        // Menghitung total biaya berdasarkan harga gedung, durasi, dan catering
        $total = ($hargaGedung * $durasi) + ($catering * $durasi);
        
        // Jika durasi penyewaan 3 hari atau lebih, diberikan diskon 10%
        $diskon = ($durasi >= 3) ? '10%' : '0%';
        if ($durasi >= 3) $total *= 0.9;

        if (isset($_POST['simpan'])) { // Mengecek apakah tombol "Simpan" telah ditekan
            $nama = $_POST['nama']; // Mengambil input nama dari form
            $identitas = $_POST['identitas']; // Mengambil input nomor identitas dari form
            $jenisKelamin = $_POST['jenisKelamin']; // Mengambil input jenis kelamin dari form
            $selectedID = $_POST['tipeGedung']; // Mengambil tipe gedung yang dipilih dari form
            $check = $catering ? 'Ya' : 'Tidak'; // Mengecek apakah pengguna memilih opsi catering
        
            // Membuat array untuk menyimpan detail pesanan
            $pesanan = [
                "Nama" => $nama,
                "Nomor Identitas" => $identitas,
                "Jenis Kelamin" => $jenisKelamin,
                "Tipe Gedung" => $selectedID,
                "Catering" => $check,
                "Durasi" => $durasi,
                "Diskon" => $diskon,
                "Total Bayar" => number_format($total, 0, ',', '.') // Format angka untuk tampilan lebih rapi
            ];
        
            // Membuat string detail pesanan untuk ditampilkan dalam alert
            $detail_pesanan = "Pesanan Berhasil!\n\n";
            foreach ($pesanan as $key => $value) { // Looping untuk menyusun detail pesanan
                $detail_pesanan .= "$key: $value\n"; // Menambahkan setiap item pesanan ke dalam string
            }
        
            // Menampilkan alert dengan detail pesanan dan mengarahkan kembali ke halaman utama
            echo "<script>
                alert(`$detail_pesanan`);
                window.location.href = 'index.php';
            </script>";
            exit(); // Menghentikan eksekusi kode setelah redirect
        }
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
                    <input type="text" class="form-control mb-3" name="durasi" placeholder="Durasi Sewa (hari)" value="<?= $_POST['durasi'] ?? '' ?>" required>
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
