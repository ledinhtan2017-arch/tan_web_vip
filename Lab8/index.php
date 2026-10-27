<?php
// Bài 2: Nâng cấp từ Bài 1 - Tạo form để người dùng nhập thông tin email

$message_status = '';
$status_class   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to      = trim($_POST['to'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $body    = trim($_POST['message'] ?? '');
    $from    = trim($_POST['from'] ?? 'sender@example.com');

    // Validate
    if (empty($to) || empty($subject) || empty($body)) {
        $message_status = '❌ Vui lòng điền đầy đủ các trường: To, Subject, Message.';
        $status_class   = 'error';
    } elseif (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $message_status = '❌ Địa chỉ email người nhận không hợp lệ.';
        $status_class   = 'error';
    } else {
        $headers  = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $result = mail($to, $subject, nl2br(htmlspecialchars($body)), $headers);

        if ($result) {
            $message_status = "✅ Email đã được gửi thành công đến <strong>" . htmlspecialchars($to) . "</strong>";
            $status_class   = 'success';
        } else {
            $message_status = '❌ Gửi email thất bại. Kiểm tra cấu hình SMTP của XAMPP.';
            $status_class   = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 2 - Form Gửi Email</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        h1 { color: #333; }
        form { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 500px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input[type="text"], input[type="email"], textarea {
            width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc;
            border-radius: 4px; box-sizing: border-box; font-size: 14px;
        }
        textarea { height: 120px; resize: vertical; }
        button {
            margin-top: 20px; padding: 12px 30px; background: #007bff; color: #fff;
            border: none; border-radius: 4px; font-size: 16px; cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .success { padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin: 15px 0; max-width: 500px; }
        .error   { padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 15px 0; max-width: 500px; }
        .nav { margin-top: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<h1>Bài 2 - Form Gửi Email</h1>

<?php if ($message_status): ?>
    <div class="<?php echo $status_class; ?>"><?php echo $message_status; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <label for="from">From (Người gửi):</label>
    <input type="email" id="from" name="from"
           value="<?php echo htmlspecialchars($_POST['from'] ?? 'sender@example.com'); ?>"
           placeholder="sender@example.com">

    <label for="to">To (Người nhận): *</label>
    <input type="email" id="to" name="to"
           value="<?php echo htmlspecialchars($_POST['to'] ?? ''); ?>"
           placeholder="recipient@example.com" required>

    <label for="subject">Subject (Tiêu đề): *</label>
    <input type="text" id="subject" name="subject"
           value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
           placeholder="Nhập tiêu đề email" required>

    <label for="message">Message (Nội dung): *</label>
    <textarea id="message" name="message" placeholder="Nhập nội dung email" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>

    <button type="submit">📧 Gửi Email</button>
</form>

<div class="nav">
    <a href="bai1.php">Bài 1 - Email cố định</a>
    <a href="bai3.php">Bài 3 - Gửi email từ CSDL</a>
</div>

</body>
</html>

