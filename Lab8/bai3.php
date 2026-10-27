<?php
// Bài 3: Gửi email cho nhiều địa chỉ - lấy email từ cơ sở dữ liệu SQL
require_once('database.php');

$message_status = '';
$status_class   = '';
$results        = [];

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_ids = $_POST['contacts'] ?? [];
    $subject      = trim($_POST['subject'] ?? '');
    $body         = trim($_POST['message'] ?? '');
    $from         = trim($_POST['from'] ?? 'sender@example.com');

    if (empty($selected_ids)) {
        $message_status = '❌ Vui lòng chọn ít nhất một người nhận.';
        $status_class   = 'error';
    } elseif (empty($subject) || empty($body)) {
        $message_status = '❌ Vui lòng điền đầy đủ Subject và Message.';
        $status_class   = 'error';
    } else {
        // Lấy thông tin contacts đã chọn
        $selected_contacts = get_contacts_by_ids($selected_ids);

        $headers  = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $success_count = 0;
        $fail_count    = 0;

        foreach ($selected_contacts as $contact) {
            $result = mail($contact['email'], $subject, nl2br(htmlspecialchars($body)), $headers);
            $results[] = [
                'name'    => $contact['name'],
                'email'   => $contact['email'],
                'success' => $result
            ];
            if ($result) {
                $success_count++;
            } else {
                $fail_count++;
            }
        }

        if ($fail_count === 0 && $success_count > 0) {
            $message_status = "✅ Đã gửi email thành công đến $success_count người nhận.";
            $status_class   = 'success';
        } elseif ($success_count > 0) {
            $message_status = "⚠️ Gửi thành công: $success_count, thất bại: $fail_count.";
            $status_class   = 'warning';
        } else {
            $message_status = "❌ Gửi email thất bại cho tất cả $fail_count người nhận. Kiểm tra cấu hình SMTP.";
            $status_class   = 'error';
        }
    }
}

// Lấy danh sách contacts từ database
try {
    $contacts = get_all_contacts();
} catch (PDOException $e) {
    $contacts = [];
    $message_status = '❌ Lỗi kết nối database. Hãy chạy file <code>create_db.sql</code> trước.<br>Error: ' . htmlspecialchars($e->getMessage());
    $status_class   = 'error';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 3 - Gửi Email Từ CSDL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        h1 { color: #333; }
        h2 { color: #555; margin-top: 25px; }
        form { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 600px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input[type="text"], input[type="email"], textarea {
            width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc;
            border-radius: 4px; box-sizing: border-box; font-size: 14px;
        }
        textarea { height: 120px; resize: vertical; }
        button {
            margin-top: 20px; padding: 12px 30px; background: #28a745; color: #fff;
            border: none; border-radius: 4px; font-size: 16px; cursor: pointer;
        }
        button:hover { background: #218838; }
        .checkbox-group { margin-top: 10px; }
        .checkbox-group label { font-weight: normal; display: flex; align-items: center; gap: 8px; margin-top: 8px; padding: 8px 12px; background: #f8f9fa; border-radius: 4px; cursor: pointer; }
        .checkbox-group label:hover { background: #e9ecef; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        .select-all { margin-top: 10px; font-size: 13px; color: #007bff; cursor: pointer; text-decoration: underline; }
        table { border-collapse: collapse; margin: 10px 0; max-width: 600px; }
        th, td { border: 1px solid #ccc; padding: 8px 14px; text-align: left; }
        th { background: #e0e0e0; }
        .success { padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin: 15px 0; max-width: 600px; }
        .error   { padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 15px 0; max-width: 600px; }
        .warning { padding: 15px; background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; border-radius: 5px; margin: 15px 0; max-width: 600px; }
        .status-ok   { color: #28a745; font-weight: bold; }
        .status-fail { color: #dc3545; font-weight: bold; }
        .nav { margin-top: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<h1>Bài 3 - Gửi Email Cho Nhiều Địa Chỉ (Từ CSDL)</h1>

<?php if ($message_status): ?>
    <div class="<?php echo $status_class; ?>"><?php echo $message_status; ?></div>
<?php endif; ?>

<?php if (!empty($results)): ?>
<h2>Kết quả gửi email</h2>
<table>
    <tr>
        <th>Tên</th>
        <th>Email</th>
        <th>Trạng thái</th>
    </tr>
    <?php foreach ($results as $r): ?>
    <tr>
        <td><?php echo htmlspecialchars($r['name']); ?></td>
        <td><?php echo htmlspecialchars($r['email']); ?></td>
        <td class="<?php echo $r['success'] ? 'status-ok' : 'status-fail'; ?>">
            <?php echo $r['success'] ? '✅ Thành công' : '❌ Thất bại'; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<form method="POST" action="">
    <label>Chọn người nhận từ danh sách: *</label>
    <span class="select-all" onclick="toggleAll()">Chọn tất cả / Bỏ chọn</span>
    <div class="checkbox-group">
        <?php if (empty($contacts)): ?>
            <p>Không có contact nào trong database. Hãy chạy <code>create_db.sql</code> để tạo dữ liệu.</p>
        <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
            <label>
                <input type="checkbox" name="contacts[]" value="<?php echo $contact['contactID']; ?>"
                    <?php echo (isset($_POST['contacts']) && in_array($contact['contactID'], $_POST['contacts'])) ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($contact['name']); ?> (<?php echo htmlspecialchars($contact['email']); ?>)
            </label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <label for="from">From (Người gửi):</label>
    <input type="email" id="from" name="from"
           value="<?php echo htmlspecialchars($_POST['from'] ?? 'sender@example.com'); ?>"
           placeholder="sender@example.com">

    <label for="subject">Subject (Tiêu đề): *</label>
    <input type="text" id="subject" name="subject"
           value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
           placeholder="Nhập tiêu đề email" required>

    <label for="message">Message (Nội dung): *</label>
    <textarea id="message" name="message" placeholder="Nhập nội dung email" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

    <button type="submit">📧 Gửi Email Cho Nhiều Người</button>
</form>

<script>
function toggleAll() {
    const checkboxes = document.querySelectorAll('input[name="contacts[]"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>

<div class="nav">
    <a href="bai1.php">Bài 1 - Email cố định</a>
    <a href="index.php">Bài 2 - Form gửi email</a>
</div>

</body>
</html>

