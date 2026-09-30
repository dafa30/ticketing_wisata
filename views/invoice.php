<?php

require '../controllers/pemesanan_tiket.php';

$idPesanan = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pesanan = $idPesanan
    ? query('SELECT * FROM tb_pemesanan_tiket WHERE id_pemesan = ' . $idPesanan)
    : query('SELECT * FROM tb_pemesanan_tiket ORDER BY id_pemesan DESC LIMIT 1');
$pesanan = $pesanan[0] ?? null;
$jadwalKeberangkatan = $pesanan && $pesanan['jadwal_keberangkatan']
    ? new DateTime($pesanan['jadwal_keberangkatan'])
    : null;
$escape = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="id">
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
    <!-- CSS Invoice -->
    <link rel="stylesheet" href="../assets/css/invoice.css">
    <!-- Icon -->
    <link rel="shortcun icon" href="../assets/img/depan3.png">
    <title>Invoice</title>
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
        <?php if (!$pesanan): ?>
            <div class="alert alert-info" role="status">Invoice belum tersedia. Silakan pesan tiket terlebih dahulu.</div>
            <a class="btn btn-primary" href="pesan_tiket.php">Pesan Tiket</a>
        <?php else: ?>
        <div class="invoice-card" id="invoice">
            <div class="row ms-5 me-0">
                <h3 class="mb-4 mt-3 text-center">Invoice Pemesanan Tiket</h3>
                <label for="nama" class="col-sm-6 col-form-label">Nama Lengkap</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $escape($pesanan['nama']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Nomer Identitas</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $escape($pesanan['nomer_identitas']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">No. HP</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $escape($pesanan['no_hp']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Tempat Wisata</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $escape($pesanan['tempat_wisata']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Tanggal Kunjungan</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $jadwalKeberangkatan ? $jadwalKeberangkatan->format('d-m-Y') : '-'; ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Jumlah Pengunjung Dewasa</label>
                <div class="col-md-6 mt-2">
                <p>: <?= $escape($pesanan['pengunjung_dewasa']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Jumlah Pengunjung Anak-Anak</label>
                <div class="col-md-6 mt-2">
                    <p>: <?= $escape($pesanan['pengunjung_anakanak']); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Harga Tiket</label>
                <div class="col-md-6 mt-2">
                    <p>: Rp. <?= number_format((int) $pesanan['harga_tiket'], 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="row ms-5 me-0">
                <label for="nama" class="col-sm-6 col-form-label">Total Harga</label>
                <div class="col-md-6 mt-2">
                    <p>: Rp. <?= number_format((int) $pesanan['total_bayar'], 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
        <div class="invoice-actions">
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="bi bi-download" aria-hidden="true"></i> Cetak / Simpan PDF
            </button>
            <a class="btn btn-outline-secondary" href="pesan_tiket.php">Pesan Tiket Lagi</a>
        </div>
        <?php endif; ?>
    </div>
    <br>
    <!-- CDN Javascript Bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
