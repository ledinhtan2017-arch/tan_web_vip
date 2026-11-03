<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bài 3 - Tìm kiếm học phần</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Tìm kiếm tên học phần</h1>
    <label for="term">Nhập tên học phần:</label>
    <input id="term" type="search" autocomplete="off" placeholder="Ví dụ: Lập trình">
    <ul id="results" aria-live="polite"></ul>
</main>
<script>
const searchInput = document.getElementById('term');
const resultList = document.getElementById('results');
let requestController;
let debounceTimer;

searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    if (requestController) requestController.abort();

    const term = searchInput.value.trim();
    resultList.replaceChildren();
    if (!term) return;

    debounceTimer = setTimeout(async () => {
        requestController = new AbortController();
        try {
            const response = await fetch(`search.php?term=${encodeURIComponent(term)}`, {
                signal: requestController.signal
            });
            if (!response.ok) throw new Error('Không thể tìm kiếm lúc này.');
            const courses = await response.json();

            if (!courses.length) {
                const empty = document.createElement('li');
                empty.textContent = 'Không tìm thấy học phần phù hợp.';
                resultList.append(empty);
                return;
            }

            for (const course of courses) {
                const item = document.createElement('li');
                item.textContent = course;
                item.addEventListener('click', () => {
                    searchInput.value = course;
                    resultList.replaceChildren();
                });
                resultList.append(item);
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                const item = document.createElement('li');
                item.textContent = error.message;
                resultList.append(item);
            }
        }
    }, 200);
});
</script>
</body>
</html>
