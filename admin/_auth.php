<?php
require __DIR__ . '/../config/database.php';
session_start();

function e($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }

function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_check() {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400);
        exit('Token tidak valid.');
    }
}

function require_admin() {
    if (empty($_SESSION['admin'])) {
        header('Location: login.php');
        exit;
    }
}

function admin_header($title) { ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= e($title) ?> - Admin Tiket Wisata</title>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-dark px-3">
    <span class="navbar-brand">Admin Tiket Wisata</span>
    <div class="navbar-nav me-auto">
        <a class="nav-link" href="index.php">Dashboard</a>
        <a class="nav-link" href="wisata.php">Katalog &amp; Harga</a>
        <a class="nav-link" href="../index.html">Situs</a>
    </div>
    <a class="btn btn-sm btn-outline-light" href="logout.php">Logout (<?= e($_SESSION['admin']) ?>)</a>
</nav>
<div class="container my-4">
<?php }

function admin_footer() { ?>
</div>
</body>
</html>
<?php }
