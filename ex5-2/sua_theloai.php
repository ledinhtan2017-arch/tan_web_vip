<?php
require_once __DIR__ . '/class/class.db.theloai.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$db_theloai = new DB_TheLoai();
$theloai_arr = $db_theloai->get_theloai($id);
if (!$theloai_arr) {
    http_response_code(404);
    $notFound = true;
} else {
    $notFound = false;
    $category = $theloai_arr[0];
    $ten_theloai = $category['TenTL'];
    $thu_tu = (string)$category['ThuTu'];
    $an_hien = (string)$category['AnHien'];
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ten_theloai = isset($_POST['ten_theloai']) ? trim($_POST['ten_theloai']) : '';
        $thu_tu = isset($_POST['thu_tu']) ? $_POST['thu_tu'] : '';
        $an_hien = isset($_POST['an_hien']) ? $_POST['an_hien'] : '';

        if ($db_theloai->sua_theloai($id, $ten_theloai, $thu_tu, $an_hien)) {
            header('Location: theloai.php?message=updated');
            exit;
        }
        $error = 'Vui lòng nhập tên hợp lệ, thứ tự là số không âm và trạng thái ẩn/hiện hợp lệ.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <?php if ($notFound): ?>
        <h1>Không tìm thấy thể loại</h1>
        <p>Thể loại không tồn tại hoặc đã bị xóa.</p>
        <a class="button secondary" href="theloai.php">Quay lại</a>
    <?php else: ?>
        <h1>Cập nhật thể loại</h1>
        <?php if ($error !== ''): ?><p class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
        <form method="post" action="sua_theloai.php?id=<?php echo $id; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                <button type="submit">Cập nhật</button>
                <a class="button secondary" href="theloai.php">Quay lại</a>
            </div>
        </form>
    <?php endif; ?>
</main>
</body>
</html>
