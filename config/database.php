<?php
// Konfigurasi koneksi. Atur password lewat config/database.local.php (tidak di-commit) atau env DB_PASS.
mysqli_report(MYSQLI_REPORT_OFF);

$dbConfig = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
    'name' => getenv('DB_NAME') ?: 'tiket_wisata',
];
$localConfig = __DIR__ . '/database.local.php';
if (is_file($localConfig)) {
    $dbConfig = array_merge($dbConfig, require $localConfig);
}

$conn = @mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['pass']);
if (!$conn) {
    http_response_code(500);
    exit('<h3>Koneksi database gagal</h3><p>' . htmlspecialchars(mysqli_connect_error()) .
        '</p><p>Salin <code>config/database.local.php.example</code> menjadi <code>config/database.local.php</code> lalu isi password MySQL Anda.</p>');
}
mysqli_set_charset($conn, 'utf8mb4');

$dbNameSafe = str_replace('`', '', $dbConfig['name']);
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbNameSafe` CHARACTER SET utf8mb4");
mysqli_select_db($conn, $dbNameSafe);

// Skema otomatis (aman dijalankan berulang)
mysqli_query($conn, 'CREATE TABLE IF NOT EXISTS tb_pemesanan_tiket (
    id_pemesan INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) DEFAULT NULL,
    nomer_identitas BIGINT(16) DEFAULT NULL,
    no_hp BIGINT(13) DEFAULT NULL,
    tempat_wisata VARCHAR(50) DEFAULT NULL,
    jadwal_keberangkatan DATETIME DEFAULT NULL,
    pengunjung_dewasa INT(4) DEFAULT NULL,
    pengunjung_anakanak INT(4) DEFAULT NULL,
    harga_tiket INT(16) DEFAULT NULL,
    total_bayar INT(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

$cols = [];
$res = mysqli_query($conn, 'SHOW COLUMNS FROM tb_pemesanan_tiket');
while ($r = mysqli_fetch_assoc($res)) {
    $cols[] = $r['Field'];
}
if (!in_array('kode_tiket', $cols, true)) {
    mysqli_query($conn, 'ALTER TABLE tb_pemesanan_tiket ADD COLUMN kode_tiket VARCHAR(20) DEFAULT NULL, ADD UNIQUE KEY uk_kode_tiket (kode_tiket)');
}
if (!in_array('created_at', $cols, true)) {
    mysqli_query($conn, 'ALTER TABLE tb_pemesanan_tiket ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
}
// Isi kode tiket untuk pesanan lama
mysqli_query($conn, "UPDATE tb_pemesanan_tiket SET kode_tiket = CONCAT('TW-', LPAD(id_pemesan, 6, '0'), '-LEGACY') WHERE kode_tiket IS NULL");

mysqli_query($conn, 'CREATE TABLE IF NOT EXISTS tb_wisata (
    id_wisata INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    harga INT NOT NULL DEFAULT 0,
    gambar VARCHAR(255) DEFAULT NULL,
    aktif TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

$jumlah = mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM tb_wisata'))[0];
if ((int) $jumlah === 0) {
    mysqli_query($conn, "INSERT INTO tb_wisata (nama, deskripsi, harga, gambar) VALUES
        ('Museum', 'Wisata edukasi sejarah dan budaya.', 70000, 'museum.jpg'),
        ('Pantai', 'Wisata pantai dengan pemandangan matahari terbenam.', 110000, 'pantai.jpg'),
        ('Taman Nasional', 'Wisata alam dan konservasi satwa.', 170000, 'tamanas.jpg')");
}

mysqli_query($conn, 'CREATE TABLE IF NOT EXISTS tb_admin (
    id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

$jumlahAdmin = mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM tb_admin'))[0];
if ((int) $jumlahAdmin === 0) {
    // Akun awal: admin / admin123 — segera ganti setelah login pertama
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO tb_admin (username, password_hash) VALUES ('admin', ?)");
    mysqli_stmt_bind_param($stmt, 's', $hash);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
