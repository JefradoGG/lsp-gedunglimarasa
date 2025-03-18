<?php
    $gedung = [
        ["VIP", 1000000, "vip.jpeg"],
        ["Ballroom", 900000, "ballroom.jpg"],
        ["Outdoor", 700000, "outdoor.jpg"]
    ];

    $pilih_gedung = $gedung[0][0];
    $pilih_harga = $gedung[0][1];
    $catering = false;
    $durasi = '';
    $total_bayar = 0;
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pilih_gedung = $_POST['gedungs'] ?? $gedung[0][0];
        $pilih_harga = array_column($gedung, 1, 0)[$pilih_gedung]; 
        $catering = isset($_POST['catering']);
        $durasi = $_POST['durasi'] ?? '';  
        $identitas = $_POST['identitas'] ?? '';
        
        if (!is_numeric($durasi)) {  
            $errors[] = "Durasi harus berupa angka dan lebih dari 0";  
        }
        if (!is_numeric($_POST['identitas'])) {  
            $errors[] = "Identitas harus berupa angka";  
        }
        if (strlen($_POST['identitas']) !== 16) {
            $errors[] = "Nomor Identitas harus 16 digit angka.";
        }

        if (empty($errors)) {
            $total_harga_gedung = $pilih_harga * $durasi;

            $diskon = ($durasi >= 3) ? 0.1 * $total_harga_gedung : 0;

            $biaya_catering = $catering ? 1200000 * $durasi : 0;

            $total_bayar = $total_harga_gedung - $diskon + $biaya_catering;
        }

        if (isset($_POST['simpan'])) { 
            $nama = $_POST['nama']; 
            $identitas = $_POST['identitas']; 
            $gender = $_POST['gender']; 
            $gedungs = $_POST['gedungs']; 
            $check = $catering ? 'Ya' : 'Tidak'; 
        
            $pesanan = [
                "Nama" => $nama,
                "Nomor Identitas" => $identitas,
                "Jenis Kelamin" => $gender,
                "Jenis Gedung" => $pilih_gedung,
                "Catering" => $check,
                "Durasi" => $durasi,
                "Diskon" => $diskon,
                "Total Bayar" => number_format($total_bayar, 0, ',', '.') 
            ];
        
            $detail_pesanan = "Pesanan Berhasil!\n\n";
            foreach ($pesanan as $key => $value) {
                $detail_pesanan .= "$key: $value\n";
            }
        
            echo "<script>
                alert(`$detail_pesanan`);
                window.location.href = 'index.php';
            </script>";
            exit();
        }
        
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h5>Form Pemesanan</h5>
            </div>
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
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" <?= ($_POST['gender'] ?? '') === 'Laki-laki' ? 'checked' : '' ?>> Laki-laki
                        <input class="form-check-input ms-3" type="radio" name="gender" value="Perempuan" <?= ($_POST['gender'] ?? '') === 'Perempuan' ? 'checked' : '' ?>> Perempuan
                    </div>
                    
                    <input type="text" class="form-control mb-3" name="identitas" placeholder="Nomor Identitas (16 digit)" value="<?= $_POST['identitas'] ?? '' ?>" required>
                    
                    <select class="form-select mb-3" name="gedungs" onchange="this.form.submit()">
                        <?php foreach  ($gedung as $indexarray => $nilai) { ?>
                            <option value="<?= $nilai[0] ?>" <?= ($nilai[0] === $pilih_gedung) ? 'selected' : '' ?>>
                                <?= $nilai[0] ?>
                            </option>
                        <?php }?>
                    </select>

                    <input type="text" class="form-control mb-3" name="harga" value="<?= number_format($pilih_harga, 0, ',', '.') ?>" readonly>
                    
                    <input type="date" class="form-control mb-3" name="tanggal" value="<?= $_POST['tanggal'] ?? '' ?>" required>
                    
                    <input type="text" class="form-control mb-3" name="durasi" placeholder="Durasi Sewa (hari)" value="<?= $durasi ?>" required>
                    
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" name="catering" <?= $catering ? 'checked' : '' ?>> Termasuk Catering (Rp 1.200.000/hari)
                    </div>

                    <input type="text" class="form-control mb-3" value="<?= $total_bayar ? number_format($total_bayar, 0, ',', '.') : '' ?>" placeholder="Total Bayar" readonly>
                    
                    <button type="submit" class="btn btn-primary">Hitung Total</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>