<?php
$conn = mysqli_connect("localhost","root","","tiket_wisata");

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
    $harga = [
        'Museum' => 70000,
        'Pantai' => 110000,
        'Taman Nasional' => 170000,
    ];

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

    $harga_tiket = $harga[$tempat_wisata];
    $total_bayar = ($pengunjung_dewasa + $pengunjung_anakanak) * $harga_tiket;
    $statement = mysqli_prepare($conn, 'INSERT INTO tb_pemesanan_tiket (nama, nomer_identitas, no_hp, tempat_wisata, jadwal_keberangkatan, pengunjung_dewasa, pengunjung_anakanak, harga_tiket, total_bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

    if (!$statement) {
        return false;
    }

    mysqli_stmt_bind_param($statement, 'sssssiiii', $nama, $nomer_identitas, $no_hp, $tempat_wisata, $jadwal_keberangkatan, $pengunjung_dewasa, $pengunjung_anakanak, $harga_tiket, $total_bayar);
    $inserted = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $inserted ? mysqli_insert_id($conn) : false;
}

?>