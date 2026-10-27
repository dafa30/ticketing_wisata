<?php
require __DIR__ . '/_auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $stmt = mysqli_prepare($conn, 'SELECT password_hash FROM tb_admin WHERE username = ?');
    $u = trim($_POST['username'] ?? '');
    mysqli_stmt_bind_param($stmt, 's', $u);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    if ($row && password_verify($_POST['password'] ?? '', $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $u;
        header('Location: index.php');
        exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login Admin</title>
</head>
<body class="bg-light">
<div class="container" style="max-width:400px;margin-top:10vh">
    <div class="card shadow-sm"><div class="card-body">
        <h4 class="mb-3">Login Admin</h4>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="mb-3"><label class="form-label">Username</label><input name="username" class="form-control" required autofocus></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-primary w-100">Masuk</button>
        </form>
    </div></div>
</div>
</body>
</html>
