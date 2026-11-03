<?php
declare(strict_types=1);

session_start();
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../config/database.php';

$username = trim($_POST['user'] ?? '');
$password = $_POST['pass'] ?? '';
if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã sinh viên và mật khẩu.']);
    exit;
}

$statement = $pdo->prepare(
    'SELECT masv, hoten, lop, matkhau FROM sinhvien WHERE masv = :masv LIMIT 1'
);
$statement->execute(['masv' => $username]);
$student = $statement->fetch();

if (!$student || !$student['matkhau'] || !password_verify($password, $student['matkhau'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Mã sinh viên hoặc mật khẩu không đúng.']);
    exit;
}

session_regenerate_id(true);
$_SESSION['code'] = $student['masv'];
$_SESSION['info'] = $student['hoten'] . ' - ' . $student['lop'];

echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công.']);
