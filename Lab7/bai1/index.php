<?php
declare(strict_types=1);

require __DIR__ . '/../config/database.php';

$classes = $pdo->query('SELECT DISTINCT lop FROM sinhvien ORDER BY lop')->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bài 1 - Danh sách sinh viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Danh sách sinh viên theo lớp</h1>
    <label for="lop">Chọn lớp:</label>
    <select id="lop">
        <option value="">-- Chọn lớp --</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e((string) $class) ?>"><?= e((string) $class) ?></option>
        <?php endforeach; ?>
    </select>
    <p id="status" role="status" aria-live="polite">Vui lòng chọn lớp.</p>
    <div id="ds"></div>
</main>
<script>
const classSelect = document.getElementById('lop');
const results = document.getElementById('ds');
const statusMessage = document.getElementById('status');

classSelect.addEventListener('change', async () => {
    results.replaceChildren();
    if (!classSelect.value) {
        statusMessage.textContent = 'Vui lòng chọn lớp.';
        return;
    }

    statusMessage.textContent = 'Đang tải danh sách...';
    try {
        const response = await fetch(`students.php?lop=${encodeURIComponent(classSelect.value)}`);
        const html = await response.text();
        if (!response.ok) throw new Error(html || 'Không thể tải danh sách.');
        results.innerHTML = html;
        statusMessage.textContent = '';
    } catch (error) {
        statusMessage.textContent = error.message;
    }
});
</script>
</body>
</html>
