<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Chỉ chạy tập lệnh này từ dòng lệnh.\n");
}

require __DIR__ . '/config/database.php';

$students = [
    ['SV001', 'Nguyễn Minh Anh', 'Đà Nẵng', 'CNTT1'],
    ['SV002', 'Trần Quốc Bảo', 'Quảng Nam', 'CNTT1'],
    ['SV003', 'Lê Thu Hà', 'Huế', 'CNTT2'],
];
$insert = $pdo->prepare(
    'INSERT IGNORE INTO sinhvien (masv, hoten, diachi, lop, matkhau)
     VALUES (:masv, :hoten, :diachi, :lop, :matkhau)'
);

foreach ($students as [$masv, $hoten, $diachi, $lop]) {
    $insert->execute([
        'masv' => $masv,
        'hoten' => $hoten,
        'diachi' => $diachi,
        'lop' => $lop,
        'matkhau' => password_hash('Lab7demo!', PASSWORD_DEFAULT),
    ]);
}

echo "Đã thêm dữ liệu mẫu nếu mã chưa tồn tại.\n";
echo "Tài khoản đăng nhập mẫu: SV001 / Lab7demo!\n";
