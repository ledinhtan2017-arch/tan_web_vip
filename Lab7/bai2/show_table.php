<?php
declare(strict_types=1);

require __DIR__ . '/database.class.php';

$table = $_GET['chon'] ?? '';
if (!in_array($table, ['giaovien', 'sinhvien', 'hocphan'], true)) {
    http_response_code(400);
    exit('Vui lòng chọn một danh sách hợp lệ.');
}

$dao = new Dao($pdo);
echo $dao->table($table);
