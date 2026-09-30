# Aplikasi Pemesanan Tiket Wisata

Aplikasi web sederhana untuk melihat pilihan wisata, memesan tiket, menghitung biaya kunjungan, dan mencetak invoice. Aplikasi dibuat dengan PHP, MySQL/MariaDB, HTML, CSS, dan JavaScript.

## Fitur

- Halaman awal dan katalog tiga pilihan wisata.
- Form pemesanan dengan data pemesan, tanggal kunjungan, serta jumlah pengunjung dewasa dan anak-anak.
- Perhitungan harga tiket dan total bayar.
- Validasi data pemesanan di server sebelum disimpan ke database.
- Invoice pesanan yang dapat dicetak atau disimpan sebagai PDF melalui fitur cetak browser.

Harga per tiket:

| Pilihan wisata | Harga |
| --- | ---: |
| Museum | Rp70.000 |
| Pantai | Rp110.000 |
| Taman Nasional | Rp170.000 |

## Persyaratan

- PHP dengan ekstensi MySQLi aktif.
- MySQL atau MariaDB.
- Web server lokal, misalnya Laragon atau XAMPP.
- Koneksi internet untuk memuat Bootstrap, Bootstrap Icons, Boxicons, dan Google Fonts dari CDN.

## Menjalankan dengan Laragon

1. Letakkan folder proyek ini di direktori web Laragon, misalnya `C:\laragon\www\ticketing_wisata`.
2. Jalankan layanan web server dan MySQL/MariaDB melalui Laragon.
3. Buat database bernama `tiket_wisata`, lalu impor file [`tiket_wisata.sql`](tiket_wisata.sql) melalui phpMyAdmin atau klien MySQL.
4. Pastikan pengaturan koneksi di [`controllers/pemesanan_tiket.php`](controllers/pemesanan_tiket.php) sesuai dengan lingkungan lokal. Nilai bawaan proyek adalah host `localhost`, pengguna `root`, kata sandi kosong, dan database `tiket_wisata`.
5. Buka `http://localhost/ticketing_wisata/` di browser.

Jika menggunakan kredensial atau port database yang berbeda, ubah argumen pada pemanggilan `mysqli_connect` di controller sebelum menjalankan aplikasi.

## Alur penggunaan

1. Dari halaman awal, pilih **Pesan Sekarang!** untuk membuka katalog.
2. Pada katalog, tinjau pilihan wisata dan harga; tombol **Pesan Tiket** membuka formulir.
3. Isi identitas pemesan, nomor HP, pilihan wisata, tanggal kunjungan, jumlah pengunjung, dan persetujuan syarat.
4. Kirim formulir. Jika valid, data disimpan dan aplikasi membuka invoice untuk pesanan tersebut.
5. Gunakan tombol cetak pada invoice untuk mencetak atau menyimpan invoice sebagai PDF.

Halaman invoice juga dapat dibuka langsung. Tanpa parameter, aplikasi menampilkan pesanan terbaru; dengan parameter `id`, aplikasi mencoba menampilkan pesanan tertentu, misalnya `views/invoice.php?id=1`.

## Struktur proyek

```text
.
├── index.html                         # Halaman awal
├── tiket_wisata.sql                   # Skema database dan tabel pemesanan
├── controllers/
│   └── pemesanan_tiket.php             # Koneksi database dan fungsi query/simpan pesanan
├── views/
│   ├── tempat_wisata.php               # Katalog wisata dan informasi harga
│   ├── pesan_tiket.php                 # Form pemesanan dan kalkulasi tampilan
│   └── invoice.php                     # Rincian invoice dan fungsi cetak
└── assets/
    ├── css/
    │   ├── home.css                    # Gaya halaman awal
    │   ├── navbar.css                  # Gaya navigasi
    │   ├── form_tiket.css              # Gaya form pemesanan
    │   └── invoice.css                 # Gaya invoice dan mode cetak
    ├── js/
    │   └── menu.js                     # Menu responsif dan efek navigasi
    └── img/                            # Gambar halaman awal dan pilihan wisata
```

## Database

File SQL membuat database `tiket_wisata` dan tabel `tb_pemesanan_tiket`. Tabel menyimpan identitas pemesan, pilihan wisata, jadwal kunjungan, jumlah pengunjung, harga tiket, dan total pembayaran. Database harus dibuat terlebih dahulu sebelum file SQL diimpor.

## Catatan

- Aplikasi ini hanya mencatat pemesanan dan menampilkan invoice; belum ada integrasi pembayaran.
- Harga ditentukan di sisi server pada `controllers/pemesanan_tiket.php`. Nilai yang ditampilkan dan dihitung pada form merupakan bantuan tampilan, bukan sumber harga saat penyimpanan.
- Seluruh aset gambar aplikasi berada di `assets/img/`.
