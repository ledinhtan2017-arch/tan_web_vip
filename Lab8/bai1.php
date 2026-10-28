<?php

require "PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/src/SMTP.php";
require "PHPMailer-master/src/Exception.php";

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {

    // Che do debug: 0 = tat, 2 = hien chi tiet
    // $mail->SMTPDebug = 2;

    $mail->isSMTP();

    $mail->CharSet = "utf-8";

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    // Thong tin nguoi gui
    $nguoigui = 'ledinhtan2017@gmail.com';

    // Mat khau ung dung Gmail
    $matkhau = 'wrqc dohx ctcx dior';

    $tennguoigui = 'Jar King';

    $mail->Username = $nguoigui;

    $mail->Password = $matkhau;

    $mail->SMTPSecure = 'ssl';

    $mail->Port = 465;

    $mail->setFrom($nguoigui, $tennguoigui);

    // Dia chi email nguoi nhan
    $to = "vuminhson1303@gmail.com";

    $to_name = "Vu Minh Son";

    $mail->addAddress($to, $to_name);

    // Gui them cho nguoi khac (neu can)
    // $mail->addAddress("another@gmail.com", "Nguoi nhan 2");

    // Dinh dang email la HTML
    $mail->isHTML(true);

    // Tieu de email
    $mail->Subject = 'Gửi thư từ php';

    // Noi dung email
    $noidungthu = "<b>Chào bạn!</b><br>Chúc an lành!";

    $mail->Body = $noidungthu;

    // Dinh kem hinh anh (bo comment neu co tep)
    // $mail->addAttachment("4.jpg", "picture");

    // Gui email
    $mail->send();

    echo 'Đã gửi mail xong';

} catch (Exception $e) {

    echo 'Mail không gửi được. Lỗi: ' . $mail->ErrorInfo;

}

?>