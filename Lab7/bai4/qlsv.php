<?php
declare(strict_types=1);

session_start();
if (!isset($_SESSION['code'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bài 4 - Thông tin sinh viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Đăng nhập thành công</h1>
    <p>Xin chào <?= htmlspecialchars((string) $_SESSION['info'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>.</p>
    <p>Mã sinh viên: <?= htmlspecialchars((string) $_SESSION['code'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <a href="logout.php">Đăng xuất</a>
</main>
</body>
</html>
