<?php
require '../controllers/pemesanan_tiket.php';

$pesanError = false;
if (isset($_POST['pesan'])) {
    $idPesanan = pesan($_POST);
    if ($idPesanan !== false) {
        header('Location: invoice.php?id=' . $idPesanan);
        exit;
    }
    $pesanError = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CDN Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CDN Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- CDN Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- CSS Navbar -->
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <!-- CSS Card -->
    <link rel="stylesheet" href="../assets/css/form_tiket.css">
    <!-- Icon -->
    <link rel="shortcun icon" href="../assets/img/depan3.png">
    <title>Pemesanan Tiket</title>
</head>
<body>
    <!-- Navbar (Navigasi Bar) -->
    <nav class="shadow">
        <a href="#" class="logo">Tiket Wisata</a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="../index.html">Home</a></li>
            <li><a href="tempat_wisata.php">Tempat Wisata</a></li>
            <li><a href="pesan_tiket.php">Pesan Tiket</a></li>
            <li><a href="invoice.php">Invoice</a></li>
        </ul>
        <div class="user">
            <a href="#">
                <i class="bx bxs-user-account"></i> Welcome!
            </a>
        </div>
    </nav>
    <br><br>
    <div class="container-lg mt-4">
        <div class="card">
            <form action="" method="post">
                <?php if ($pesanError): ?>
                    <div class="alert alert-danger mx-4 mt-4" role="alert">Pemesanan gagal. Periksa kembali data dan jumlah pengunjung.</div>
                <?php endif; ?>
                <div class="row ms-5 me-0 mb-3">
                    <h3 class="mb-4 mt-3">Form Pemesanan</h3>
                    <label for="nama" class="col-sm-5 col-form-label">Nama Lengkap</label>
                    <div class="col-md-6">
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pemesan tiket" maxlength="50" required>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-3">
                    <label for="nomer_identitas" class="col-sm-5 col-form-label">Nomer Identitas</label>
                    <div class="col-md-6">
                        <input type="text" name="nomer_identitas" class="form-control" inputmode="numeric" pattern="[0-9]{1,16}" maxlength="16" placeholder="Masukkan nomer identitas" required>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-3">
                    <label for="no_hp" class="col-sm-5 col-form-label">No. HP</label>
                    <div class="col-md-6">
                        <input type="text" name="no_hp" class="form-control" inputmode="numeric" pattern="[0-9]{1,13}" maxlength="13" placeholder="62813xxxxxx" required>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-3">
                    <label for="tempat_wisata" class="col-sm-5 col-form-label">Tempat Wisata</label>
                    <div class="col-md-6">
                        <select class="form-select" name="tempat_wisata" id="tempat_wisata" onchange="hargaTiket()" required>
                            <option value="" disabled selected>Pilih Jenis Wisata</option>
                            <option value="Museum">Museum</option>
                            <option value="Pantai">Pantai</option>
                            <option value="Taman Nasional">Taman Nasional</option>
                        </select>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-3">
                    <label for="jadwal_keberangkatan" class="col-sm-5 col-form-label">Tanggal Kunjungan</label>
                    <div class="col-md-6">
                        <input type="date" name="jadwal_keberangkatan" class="form-control" required>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-0">
                    <label for="pengunjung_dewasa" class="col-sm-5 col-form-label" style="margin-top: -7px;">Pengunjung Dewasa<br>
                        <small style="font-size: 12px;">(Usia > 12)</small>
                    </label>
                    <div class="col-md-6">
                        <input type="number" name="pengunjung_dewasa" id="pengunjung_dewasa" class="form-control" min="0" placeholder="Jumlah Pengunjung Dewasa" required
                        max="9999" oninput="hitungTotalBayar()">
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-1">
                    <label for="pengunjung_anakanak" class="col-sm-5 col-form-label" style="margin-top: -7px;">Pengunjung Anak-Anak<br>
                        <small style="font-size: 12px;">Usia di bawah 12 tahun</small>
                    </label>
                    <div class="col-md-6">
                        <input type="number" name="pengunjung_anakanak" id="pengunjung_anakanak" class="form-control" min="0" placeholder="Jumlah Pengunjung Anak-Anak" required
                        max="9999" oninput="hitungTotalBayar()">
                    </div>
                </div>
                <div class="row ms-5 me-0">
                    <label for="harga_tiket" class="col-sm-5 col-form-label">Harga Tiket</label>
                    <div class="col-md-6">
                        <p class="mt-1" style="display: flex;">
                            Rp. <input type="number" name="harga_tiket" id="harga_tiket" class="form-control" readonly required 
                            style="border: none; margin-top: -5px;">
                        </p>
                    </div>
                </div>
                <div class="row ms-5 me-0">
                    <label for="total_bayar" class="col-sm-5 col-form-label">Total Bayar</label>
                    <div class="col-md-6">
                        <p class="mt-1" style="display: flex;">
                            Rp. <input type="number" name="total_bayar" id="total_bayar" class="form-control" readonly required
                            style="border: none; margin-top: -5px;">
                        </p>
                    </div>
                </div>
                <div class="row ms-5 me-0">
                    <div class="col-md-6 offset-sm-5">
                        <button type="button" class="btn btn-primary" id="hitungTotal" onclick="hitungTotalBayar()">Hitung Total Bayar</button>
                    </div>
                </div>
                <div class="row ms-5 me-0 mb-2">
                    <label for="total_bayar" class="col-sm-11 col-form-label">
                        <input type="checkbox" name="setuju" required>
                        Saya dan/atau rombongan telah membaca, memahami, dan setuju berdasarkan syarat dan ketentuan yang telah
                        ditetapkan.
                    </label>
                </div>
                <div class="row ms-5 me-0 mb-2">
                    <div class="btn-inline">
                        <button type="button" class="btn btn-md btn-secondary m-1" data-bs-dismiss="modal" style="width: 268px;">
                            <a href="tempat_wisata.php" class="text-white">Cancel</a>
                        </button>
                        <button type="submit" name="pesan" class="btn btn-md btn-primary btn-outline-info text-light" style="width: 268px;">
                            Pesan Tiket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <!-- CDN Javascript Bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk mengisi value harga tiket sesuai kelas Wisata yang dipilih
        function hargaTiket() {
            const kelas = document.getElementById("tempat_wisata").value;
            const hargaTiket = document.getElementById("harga_tiket");

            if (kelas == "Museum") {
                hargaTiket.value = 70000;
            } else if (kelas == "Pantai") {
                hargaTiket.value = 110000;
            } else if (kelas == "Taman Nasional") {
                hargaTiket.value = 170000;
            } else {
                hargaTiket.value = 0;
            }
            hitungTotalBayar();
        }

        function hitungTotalBayar() {
            const pengunjungDewasa = parseInt(document.getElementById("pengunjung_dewasa").value) || 0;
            const pengunjungAnak = parseInt(document.getElementById("pengunjung_anakanak").value) || 0;
            const hargaTiket = parseInt(document.getElementById("harga_tiket").value) || 0;
            const totalBayar = document.getElementById("total_bayar");

            const total = (pengunjungDewasa + pengunjungAnak) * hargaTiket;
            totalBayar.value = total;
        }

    </script>
</body>
</html>
