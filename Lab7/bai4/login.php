<?php
declare(strict_types=1);

session_start();
if (isset($_SESSION['code'])) {
    header('Location: qlsv.php');
    exit;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bài 4 - Đăng nhập Ajax</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Đăng nhập</h1>
    <form id="login-form">
        <label for="us">Mã sinh viên</label>
        <input id="us" name="user" autocomplete="username" required>
        <label for="pw">Mật khẩu</label>
        <input id="pw" name="pass" type="password" autocomplete="current-password" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <p id="notice" role="status" aria-live="polite"></p>
</main>
<script>
const form = document.getElementById('login-form');
const notice = document.getElementById('notice');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    notice.textContent = 'Đang kiểm tra...';
    try {
        const response = await fetch('check.php', {
            method: 'POST',
            body: new FormData(form),
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();
        notice.textContent = result.message;
        notice.className = result.success ? 'success' : 'error';
        if (result.success) window.location.href = 'qlsv.php';
    } catch (error) {
        notice.textContent = 'Không thể kết nối máy chủ. Vui lòng thử lại.';
        notice.className = 'error';
    }
});
</script>
</body>
</html>
