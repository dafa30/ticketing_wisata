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
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <!-- Icon -->
    <link rel="shortcut icon" href="../assets/img/depan3.png">
    <title>Tempat Wisata</title>
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
    <!-- Container -->
    <div class="container-md mt-5">
        <h2 class="mb-5" style="text-align: center;">Tempat Wisata</h2>
        <div class="row">
            <!-- Card jenis wisata Museum-->
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <div class="card" style="height: 25rem;">
                    <img src="../assets/img/museum.jpg" class="img-thumbnail" alt="Museum" style="object-fit: cover; height: 225px;">
                    <div class="card-body py-2">
                        <h4 class="card-title mb-2">Museum Nasional</h4>
                        <hr>
                        <p class="card-text mb-0">
                            Wisata : Museum Nasional Indonesia
                        </p>
                        <p class="card-text mb-0">
                            Pengunjung : 150
                        </p>
                        <p class="card-text mb-1">
                            Fasilitas : Makanan Ringan
                        </p>
                        <a class="btn btn-md btn-primary btn-outline-info" data-bs-toggle="modal" data-bs-target="#Museum">
                            <i class="bi bi-info-circle text-white"> Cek Harga</i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card jenis wisata Pantai  -->
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <div class="card" style="height: 25rem;">
                    <img src="../assets/img/pantai2.png" class="img-thumbnail" alt="Pantai" style="object-fit: cover; height: 225px;">
                    <div class="card-body py-2">
                        <h4 class="card-title mb-2">Pantai Bali</h4>
                        <hr>
                        <p class="card-text mb-0">
                             Wisata : Pantai Bali
                        </p>
                        <p class="card-text mb-0">
                            Pengunjung : 70
                        </p>
                        <p class="card-text mb-1">
                            Fasilitas : Makan dan Tikar
                        </p>
                        <a class="btn btn-md btn-primary btn-outline-info" data-bs-toggle="modal" data-bs-target="#Pantai">
                            <i class="bi bi-info-circle text-white"> Cek Harga</i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card jenis wisata Taman Nasional -->
            <div class="col-12 col-md-6 col-lg-4 mt-3">
                <div class="card" style="height: 25rem;">
                    <img src="../assets/img/tamanas.jpg" class="img-thumbnail" alt="Taman" style="object-fit: cover; height: 225px;">
                    <div class="card-body py-2">
                        <h4 class="card-title mb-2">Taman Nasional</h4>
                        <hr>
                        <p class="card-text mb-0">
                            Wisata : Taman Nasional Ujung Kulon
                        </p>
                        <p class="card-text mb-0">
                            Pengunjung : 50
                        </p>
                        <p class="card-text mb-1">
                            Fasilitas : Makan dan Minum
                        </p>
                        <a class="btn btn-md btn-primary btn-outline-info" data-bs-toggle="modal" data-bs-target="#Taman">
                            <i class="bi bi-info-circle text-white"> Cek Harga</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Harga Museum-->
    <div class="modal fade mt-4" id="Museum" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Harga Tiket & Video Museum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-primary table-striped table-bordered border-primary" style="text-align: center; vertical-align: middle;">
                        <tr>
                            <th>Wisata</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                        </tr>
                        <tr>
                            <td>Museum</td>
                            <td>Museum Indonesia</td>
                            <td>Rp. 70.000</td>
                        </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <h6>Video Tentang Museum Nasional:</h6>
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/DcsKmapxgW0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: -10px;">
                    <a class="btn btn-secondary" data-bs-dismiss="modal">Batal</a>
                    <a href="pesan_tiket.php" class="btn btn-primary btn-outline-info text-white">Pesan Tiket</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Harga Pantai-->
    <div class="modal fade mt-4" id="Pantai" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Harga Tiket & Video Pantai Bali</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-primary table-striped table-bordered border-primary" style="text-align: center; vertical-align: middle;">
                        <tr>
                            <th>Wisata</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                        </tr>
                        <tr>
                            <td>Pantai</td>
                            <td>Bali</td>
                            <td>Rp. 110.000</td>
                        </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <h6>Video Tentang Pantai Bali:</h6>
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/4mDLD6X_L6M" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: -10px;">
                    <a class="btn btn-secondary" data-bs-dismiss="modal">Batal</a>
                    <a href="pesan_tiket.php" class="btn btn-primary btn-outline-info text-white">Pesan Tiket</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Harga Taman Nasional-->
    <div class="modal fade mt-4" id="Taman" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Harga Tiket & Video Taman Nasional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-primary table-striped table-bordered border-primary" style="text-align: center; vertical-align: middle;">
                        <tr>
                            <th>Wisata</th>
                            <th>Tujuan</th>
                            <th>Harga</th>
                        </tr>
                        <tr>
                            <td>Taman Nasional</td>
                            <td>Ujung Kulon</td>
                            <td>Rp. 170.000</td>
                        </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <h6>Video Tentang Taman Nasional Ujung Kulon:</h6>
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/_1ZQ4UZWhks" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: -10px;">
                    <a class="btn btn-secondary" data-bs-dismiss="modal">Batal</a>
                    <a href="pesan_tiket.php" class="btn btn-primary btn-outline-info text-white">Pesan Tiket</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Script Javascript untuk menu responsive -->
    <script src="../assets/js/menu.js"></script>
    <!-- CDN Javascript Bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
