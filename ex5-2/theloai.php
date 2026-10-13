<?php
require_once __DIR__ . '/class/class.db.theloai.php';

$db_theloai = new DB_TheLoai();
$theloai_arr = $db_theloai->get_theloai();
$message = isset($_GET['message']) ? $_GET['message'] : '';
$messages = [
    'added' => 'Thêm thể loại thành công.',
    'updated' => 'Cập nhật thể loại thành công.',
    'deleted' => 'Xóa thể loại thành công.',
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản trị thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <h1>Quản trị thể loại</h1>
    <?php if (isset($messages[$message])): ?>
        <p class="message"><?php echo htmlspecialchars($messages[$message], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <div class="toolbar">
        <a class="button" href="theloai_them.php">Thêm thể loại</a>
    </div>
    <?php if (!$theloai_arr): ?>
        <p>Chưa có thể loại nào. Hãy thêm thể loại đầu tiên.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Tên thể loại</th>
                <th>Thứ tự</th>
                <th>Ẩn/Hiện</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($theloai_arr as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['TenTL'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo (int)$item['ThuTu']; ?></td>
                    <td><?php echo (int)$item['AnHien'] === 1 ? 'Hiện' : 'Ẩn'; ?></td>
                    <td>
                        <div class="actions">
                            <a class="button" href="sua_theloai.php?id=<?php echo (int)$item['idTL']; ?>">Sửa</a>
                            <form action="delete.php" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thể loại này?');">
                                <input type="hidden" name="id" value="<?php echo (int)$item['idTL']; ?>">
                                <button class="danger" type="submit">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
</body>
</html>
