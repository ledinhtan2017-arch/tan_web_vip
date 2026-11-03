<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bài 2 - Hướng đối tượng PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>OOP với PHP và AJAX</h1>
    <label for="chon">Chọn danh sách:</label>
    <select id="chon">
        <option value="">-- Chọn --</option>
        <option value="giaovien">Giáo viên</option>
        <option value="sinhvien">Sinh viên</option>
        <option value="hocphan">Học phần</option>
    </select>
    <p id="status" role="status" aria-live="polite"></p>
    <section id="info"></section>
</main>
<script>
const selector = document.getElementById('chon');
const info = document.getElementById('info');
const statusMessage = document.getElementById('status');

selector.addEventListener('change', async () => {
    info.replaceChildren();
    if (!selector.value) {
        statusMessage.textContent = '';
        return;
    }

    statusMessage.textContent = 'Đang tải dữ liệu...';
    try {
        const response = await fetch(`show_table.php?chon=${encodeURIComponent(selector.value)}`);
        const html = await response.text();
        if (!response.ok) throw new Error(html || 'Không thể tải dữ liệu.');
        info.innerHTML = html;
        statusMessage.textContent = '';
    } catch (error) {
        statusMessage.textContent = error.message;
    }
});
</script>
</body>
</html>
