<?php
require_once __DIR__ . '/class/class.db.theloai.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Phương thức không được hỗ trợ.');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$db_theloai = new DB_TheLoai();
if ($id > 0 && $db_theloai->xoa_theloai($id)) {
    header('Location: theloai.php?message=deleted');
    exit;
}

http_response_code(400);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Xóa thể loại thất bại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <h1>Không thể xóa thể loại</h1>
    <p>ID thể loại không hợp lệ. Vui lòng quay lại danh sách và thử lại.</p>
    <a class="button secondary" href="theloai.php">Quay lại danh sách</a>
</main>
</body>
</html>
