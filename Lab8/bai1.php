<?php
// Bài 1: Gửi email cố định theo địa chỉ cho trước

$to      = 'recipient@example.com';    // Địa chỉ email người nhận (thay đổi theo yêu cầu)
$subject = 'Test Email from PHP';
$message = 'Xin chào! Đây là email gửi từ PHP bằng hàm mail().';
$headers = "From: sender@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$result = mail($to, $subject, $message, $headers);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 1 - Gửi Email Cố Định</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        h1 { color: #333; }
        .success { padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin: 15px 0; }
        .error   { padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 15px 0; }
        .info    { padding: 15px; background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; border-radius: 5px; margin: 15px 0; }
        table    { border-collapse: collapse; margin: 10px 0; }
        th, td   { border: 1px solid #ccc; padding: 8px 14px; text-align: left; }
        th       { background: #e0e0e0; }
    </style>
</head>
<body>

<h1>Bài 1 - Gửi Email Cố Định</h1>

<table>
    <tr><th>To</th><td><?php echo htmlspecialchars($to); ?></td></tr>
    <tr><th>Subject</th><td><?php echo htmlspecialchars($subject); ?></td></tr>
    <tr><th>Message</th><td><?php echo htmlspecialchars($message); ?></td></tr>
</table>

<?php if ($result): ?>
    <div class="success">✅ Email đã được gửi thành công đến <strong><?php echo htmlspecialchars($to); ?></strong></div>
<?php else: ?>
    <div class="error">❌ Gửi email thất bại. Hãy kiểm tra cấu hình SMTP trong php.ini hoặc sendmail.ini của XAMPP.</div>
    <div class="info">
        <strong>Hướng dẫn cấu hình XAMPP để gửi email:</strong><br>
        1. Mở file <code>C:\xampp\php\php.ini</code>, tìm <code>[mail function]</code><br>
        2. Sửa: <code>SMTP = smtp.gmail.com</code>, <code>smtp_port = 587</code><br>
        3. Sửa: <code>sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"</code><br>
        4. Mở file <code>C:\xampp\sendmail\sendmail.ini</code><br>
        5. Cấu hình: <code>smtp_server=smtp.gmail.com</code>, <code>smtp_port=587</code>, <code>auth_username</code>, <code>auth_password</code><br>
        6. Khởi động lại Apache.
    </div>
<?php endif; ?>

<p><a href="index.php">← Quay lại trang chính (Bài 2)</a></p>

</body>
</html>

