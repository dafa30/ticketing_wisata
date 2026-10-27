<?php
require __DIR__ . '/_auth.php';
require_admin();

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $aksi = $_POST['aksi'] ?? '';
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $gambar = trim($_POST['gambar'] ?? '');
    $harga = filter_var($_POST['harga'] ?? null, FILTER_VALIDATE_INT);
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    if ($aksi === 'hapus' && $id) {
        $stmt = mysqli_prepare($conn, 'DELETE FROM tb_wisata WHERE id_wisata = ?');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $pesan = 'Wisata dihapus.';
    } elseif (in_array($aksi, ['tambah', 'ubah'], true)) {
        if ($nama === '' || strlen($nama) > 50 || $harga === false || $harga < 0 || ($aksi === 'ubah' && !$id)) {
            $pesan = 'Data tidak valid.';
        } elseif ($aksi === 'tambah') {
            $stmt = mysqli_prepare($conn, 'INSERT INTO tb_wisata (nama, deskripsi, harga, gambar, aktif) VALUES (?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssisi', $nama, $deskripsi, $harga, $gambar, $aktif);
            $pesan = mysqli_stmt_execute($stmt) ? 'Wisata ditambahkan.' : 'Gagal (nama mungkin sudah ada).';
        } else {
            $stmt = mysqli_prepare($conn, 'UPDATE tb_wisata SET nama = ?, deskripsi = ?, harga = ?, gambar = ?, aktif = ? WHERE id_wisata = ?');
            mysqli_stmt_bind_param($stmt, 'ssisii', $nama, $deskripsi, $harga, $gambar, $aktif, $id);
            $pesan = mysqli_stmt_execute($stmt) ? 'Wisata diperbarui.' : 'Gagal (nama mungkin sudah ada).';
        }
    }
}

$daftar = [];
$r = mysqli_query($conn, 'SELECT * FROM tb_wisata ORDER BY nama');
while ($x = mysqli_fetch_assoc($r)) { $daftar[] = $x; }

admin_header('Katalog & Harga');
?>
<h3 class="mb-3">Katalog Wisata &amp; Harga Tiket</h3>
<?php if ($pesan): ?><div class="alert alert-info"><?= e($pesan) ?></div><?php endif; ?>
<table class="table table-bordered bg-white align-middle">
    <thead><tr><th>Nama</th><th>Deskripsi</th><th>Harga (Rp)</th><th>Gambar</th><th>Aktif</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($daftar as $w): ?>
        <tr>
            <td><form method="post" id="f<?= (int) $w['id_wisata'] ?>"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $w['id_wisata'] ?>"></form><input form="f<?= (int) $w['id_wisata'] ?>" name="nama" class="form-control form-control-sm" maxlength="50" value="<?= e($w['nama']) ?>" required></td>
            <td><input form="f<?= (int) $w['id_wisata'] ?>" name="deskripsi" class="form-control form-control-sm" value="<?= e($w['deskripsi']) ?>"></td>
            <td><input type="number" form="f<?= (int) $w['id_wisata'] ?>" name="harga" min="0" class="form-control form-control-sm" value="<?= (int) $w['harga'] ?>" required></td>
            <td><input form="f<?= (int) $w['id_wisata'] ?>" name="gambar" class="form-control form-control-sm" value="<?= e($w['gambar']) ?>"></td>
            <td><input type="checkbox" form="f<?= (int) $w['id_wisata'] ?>" name="aktif" <?= $w['aktif'] ? 'checked' : '' ?>></td>
            <td class="text-nowrap">
                <button form="f<?= (int) $w['id_wisata'] ?>" name="aksi" value="ubah" class="btn btn-sm btn-primary">Simpan</button>
                <button form="f<?= (int) $w['id_wisata'] ?>" name="aksi" value="hapus" class="btn btn-sm btn-danger" onclick="return confirm('Hapus wisata ini?')">Hapus</button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<h5>Tambah Wisata</h5>
<form method="post" class="row g-2 bg-white p-3 border rounded">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <div class="col-md-3"><input name="nama" class="form-control" placeholder="Nama" maxlength="50" required></div>
    <div class="col-md-3"><input name="deskripsi" class="form-control" placeholder="Deskripsi"></div>
    <div class="col-md-2"><input type="number" name="harga" min="0" class="form-control" placeholder="Harga" required></div>
    <div class="col-md-2"><input name="gambar" class="form-control" placeholder="file gambar"></div>
    <div class="col-md-1 pt-2"><label><input type="checkbox" name="aktif" checked> Aktif</label></div>
    <div class="col-md-1"><button name="aksi" value="tambah" class="btn btn-success w-100">Tambah</button></div>
</form>
<?php admin_footer();
