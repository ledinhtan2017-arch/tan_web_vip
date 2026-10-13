<?php
require_once __DIR__ . '/class/class.db.theloai.php';

$error = '';
$ten_theloai = '';
$thu_tu = '0';
$an_hien = '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_theloai = isset($_POST['ten_theloai']) ? trim($_POST['ten_theloai']) : '';
    $thu_tu = isset($_POST['thu_tu']) ? $_POST['thu_tu'] : '0';
    $an_hien = isset($_POST['an_hien']) ? $_POST['an_hien'] : '1';

    $db_theloai = new DB_TheLoai();
    if ($db_theloai->them_theloai($ten_theloai, $thu_tu, $an_hien)) {
        header('Location: theloai.php?message=added');
        exit;
    }
    $error = 'Vui lòng nhập tên hợp lệ, thứ tự là số không âm và trạng thái ẩn/hiện hợp lệ.';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <h1>Thêm thể loại</h1>
    <?php if ($error !== ''): ?><p class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
    <form method="post" action="theloai_them.php">
        <label for="ten_theloai">Tên thể loại</label>
        <input id="ten_theloai" type="text" name="ten_theloai" maxlength="100" value="<?php echo htmlspecialchars($ten_theloai, ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="thu_tu">Thứ tự</label>
        <input id="thu_tu" type="number" name="thu_tu" min="0" max="255" value="<?php echo htmlspecialchars($thu_tu, ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="an_hien">Ẩn/Hiện</label>
        <select id="an_hien" name="an_hien">
            <option value="1" <?php echo $an_hien === '1' ? 'selected' : ''; ?>>Hiện</option>
            <option value="0" <?php echo $an_hien === '0' ? 'selected' : ''; ?>>Ẩn</option>
        </select>

        <div class="form-actions">
            <button type="submit">Thêm thể loại</button>
            <a class="button secondary" href="theloai.php">Quay lại</a>
        </div>
    </form>
</main>
</body>
</html>
