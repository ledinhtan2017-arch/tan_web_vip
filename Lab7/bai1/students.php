<?php
declare(strict_types=1);

require __DIR__ . '/../config/database.php';

$class = trim($_GET['lop'] ?? '');
if ($class === '') {
    http_response_code(400);
    exit('Vui lòng chọn lớp.');
}

$statement = $pdo->prepare(
    'SELECT masv, hoten, diachi FROM sinhvien WHERE lop = :lop ORDER BY masv'
);
$statement->execute(['lop' => $class]);
$students = $statement->fetchAll();

if (!$students) {
    echo '<p>Lớp này chưa có sinh viên.</p>';
    exit;
}
?>
<table>
    <thead>
    <tr><th>TT</th><th>Mã số</th><th>Họ tên</th><th>Địa chỉ</th></tr>
    </thead>
    <tbody>
    <?php foreach ($students as $index => $student): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= e($student['masv']) ?></td>
            <td><?= e($student['hoten']) ?></td>
            <td><?= e($student['diachi']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
