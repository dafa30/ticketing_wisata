<?php
require __DIR__ . '/_auth.php';
require_admin();

function scalar($sql) {
    global $conn;
    return mysqli_fetch_row(mysqli_query($conn, $sql))[0];
}
function rows($sql) {
    global $conn;
    $out = [];
    $r = mysqli_query($conn, $sql);
    while ($x = mysqli_fetch_assoc($r)) { $out[] = $x; }
    return $out;
}
$rp = static fn($n) => 'Rp ' . number_format((int) $n, 0, ',', '.');

$hariIni = rows('SELECT COUNT(*) AS pesanan, COALESCE(SUM(pengunjung_dewasa + pengunjung_anakanak),0) AS tiket, COALESCE(SUM(total_bayar),0) AS omzet FROM tb_pemesanan_tiket WHERE DATE(created_at) = CURDATE()')[0];
$total = rows('SELECT COUNT(*) AS pesanan, COALESCE(SUM(pengunjung_dewasa + pengunjung_anakanak),0) AS tiket, COALESCE(SUM(total_bayar),0) AS omzet FROM tb_pemesanan_tiket')[0];
$harian = rows('SELECT DATE(created_at) AS tgl, COUNT(*) AS pesanan, SUM(pengunjung_dewasa + pengunjung_anakanak) AS tiket, SUM(total_bayar) AS omzet FROM tb_pemesanan_tiket GROUP BY DATE(created_at) ORDER BY tgl DESC LIMIT 14');
$perWisata = rows('SELECT tempat_wisata, SUM(pengunjung_dewasa + pengunjung_anakanak) AS tiket, SUM(total_bayar) AS omzet FROM tb_pemesanan_tiket GROUP BY tempat_wisata ORDER BY omzet DESC');
$terbaru = rows('SELECT * FROM tb_pemesanan_tiket ORDER BY id_pemesan DESC LIMIT 20');

admin_header('Dashboard');
?>
<h3 class="mb-3">Dashboard Penjualan</h3>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Pesanan hari ini</small><h4><?= (int) $hariIni['pesanan'] ?></h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Tiket terjual hari ini</small><h4><?= (int) $hariIni['tiket'] ?></h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Pendapatan hari ini</small><h4><?= e($rp($hariIni['omzet'])) ?></h4></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small>Total pendapatan</small><h4><?= e($rp($total['omzet'])) ?></h4><small><?= (int) $total['tiket'] ?> tiket / <?= (int) $total['pesanan'] ?> pesanan</small></div></div></div>
</div>
<div class="row g-3">
    <div class="col-lg-6">
        <h5>Penjualan Harian (14 hari terakhir)</h5>
        <table class="table table-sm table-bordered bg-white">
            <thead><tr><th>Tanggal</th><th>Pesanan</th><th>Tiket</th><th>Pendapatan</th></tr></thead>
            <tbody>
            <?php foreach ($harian as $h): ?>
                <tr><td><?= e($h['tgl']) ?></td><td><?= (int) $h['pesanan'] ?></td><td><?= (int) $h['tiket'] ?></td><td><?= e($rp($h['omzet'])) ?></td></tr>
            <?php endforeach; if (!$harian): ?><tr><td colspan="4" class="text-center">Belum ada data.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">
        <h5>Per Tempat Wisata</h5>
        <table class="table table-sm table-bordered bg-white">
            <thead><tr><th>Wisata</th><th>Tiket</th><th>Pendapatan</th></tr></thead>
            <tbody>
            <?php foreach ($perWisata as $p): ?>
                <tr><td><?= e($p['tempat_wisata']) ?></td><td><?= (int) $p['tiket'] ?></td><td><?= e($rp($p['omzet'])) ?></td></tr>
            <?php endforeach; if (!$perWisata): ?><tr><td colspan="3" class="text-center">Belum ada data.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<h5 class="mt-3">Pesanan Terbaru</h5>
<div class="table-responsive">
<table class="table table-sm table-bordered bg-white">
    <thead><tr><th>Kode</th><th>Nama</th><th>Wisata</th><th>Kunjungan</th><th>Tiket</th><th>Total</th><th>Dipesan</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($terbaru as $t): ?>
        <tr>
            <td><?= e($t['kode_tiket']) ?></td><td><?= e($t['nama']) ?></td><td><?= e($t['tempat_wisata']) ?></td>
            <td><?= e(substr((string) $t['jadwal_keberangkatan'], 0, 10)) ?></td>
            <td><?= (int) $t['pengunjung_dewasa'] + (int) $t['pengunjung_anakanak'] ?></td>
            <td><?= e($rp($t['total_bayar'])) ?></td><td><?= e($t['created_at']) ?></td>
            <td><a href="../views/invoice.php?id=<?= (int) $t['id_pemesan'] ?>" target="_blank">E-Ticket</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php admin_footer();
