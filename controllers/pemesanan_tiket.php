<?php
require __DIR__ . '/../config/database.php';

// Fungsi query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Daftar tempat wisata dari katalog
function daftar_wisata($hanyaAktif = false) {
    return query('SELECT * FROM tb_wisata' . ($hanyaAktif ? ' WHERE aktif = 1' : '') . ' ORDER BY nama');
}

// Fungsi untuk CREATE
function pesan($pesan) {
    global $conn;
    $nama = trim($pesan['nama'] ?? '');
    $nomer_identitas = trim($pesan['nomer_identitas'] ?? '');
    $no_hp = trim($pesan['no_hp'] ?? '');
    $tempat_wisata = $pesan['tempat_wisata'] ?? '';
    $jadwal_keberangkatan = $pesan['jadwal_keberangkatan'] ?? '';
    $pengunjung_dewasa = filter_var($pesan['pengunjung_dewasa'] ?? null, FILTER_VALIDATE_INT);
    $pengunjung_anakanak = filter_var($pesan['pengunjung_anakanak'] ?? null, FILTER_VALIDATE_INT);
    $harga = [];
    foreach (daftar_wisata(true) as $w) {
        $harga[$w['nama']] = (int) $w['harga'];
    }

    if (
        $nama === '' || strlen($nama) > 50 ||
        !ctype_digit($nomer_identitas) || strlen($nomer_identitas) > 16 ||
        !ctype_digit($no_hp) || strlen($no_hp) > 13 ||
        !isset($harga[$tempat_wisata]) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $jadwal_keberangkatan) ||
        $pengunjung_dewasa === false || $pengunjung_dewasa < 0 ||
        $pengunjung_anakanak === false || $pengunjung_anakanak < 0 ||
        ($pengunjung_dewasa + $pengunjung_anakanak) < 1
    ) {
        return false;
    }

    $kode = 'TW-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    $harga_tiket = $harga[$tempat_wisata];
    $total_bayar = ($pengunjung_dewasa + $pengunjung_anakanak) * $harga_tiket;
    $statement = mysqli_prepare($conn, 'INSERT INTO tb_pemesanan_tiket (kode_tiket, nama, nomer_identitas, no_hp, tempat_wisata, jadwal_keberangkatan, pengunjung_dewasa, pengunjung_anakanak, harga_tiket, total_bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    if (!$statement) {
        return false;
    }

    mysqli_stmt_bind_param($statement, 'ssssssiiii', $kode, $nama, $nomer_identitas, $no_hp, $tempat_wisata, $jadwal_keberangkatan, $pengunjung_dewasa, $pengunjung_anakanak, $harga_tiket, $total_bayar);
    $inserted = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $inserted ? mysqli_insert_id($conn) : false;
}

?>