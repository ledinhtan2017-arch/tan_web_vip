<?php

require "PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/src/SMTP.php";
require "PHPMailer-master/src/Exception.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {

        // Che do debug
        // $mail->SMTPDebug = 2;

        $mail->isSMTP();

        $mail->CharSet = "utf-8";

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        // Thong tin Gmail nguoi gui
        $nguoigui = 'your_email@gmail.com';

        $matkhau = 'YOUR_APP_PASSWORD';

        $tennguoigui = 'le quan';

        $mail->Username = $nguoigui;

        $mail->Password = $matkhau;

        $mail->SMTPSecure = 'ssl';

        $mail->Port = 465;

        $mail->setFrom($nguoigui, $tennguoigui);

        // Lay email nguoi nhan tu form
        $to = $_POST['email'];

        $to_name = "bạn";

        // Lay tieu de email
        $tieude = $_POST['tieude'];

        $mail->addAddress($to, $to_name);

        // Neu muon gui cho nguoi nhan thu hai
        // $mail->addAddress("second@gmail.com", "Nguoi nhan 2");

        // Dinh dang HTML
        $mail->isHTML(true);

        $mail->Subject = $tieude;

        // Lay noi dung tu form
        $noidungthu = '
            <div class="card" style="width: 18rem;">
                <div class="card-body">

                    <h5 class="card-title">
                        <b>Xin chào ' . $to_name . '</b>
                    </h5>

                    <h6 class="card-subtitle mb-2 text-muted">
                    </h6>

                    <p class="card-text">'
                        . $_POST['content'] .
                    '</p>

                </div>
            </div>';

        $mail->Body = $noidungthu;

        // Xu ly file dinh kem
        if (
            isset($_FILES['file']) &&
            $_FILES['file']['error'] === UPLOAD_ERR_OK
        ) {

            // Tao file tam
            $uploadfile = tempnam(
                sys_get_temp_dir(),
                sha1($_FILES['file']['name'])
            );

            if (
                $uploadfile !== false &&
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    $uploadfile
                )
            ) {

                $mail->addAttachment(
                    $uploadfile,
                    $_FILES['file']['name']
                );

            }
        }

        // Gui email
        if ($mail->send()) {

            header("Location:index.php");
            exit;

        }

    } catch (Exception $e) {

        echo 'Mail không gửi được. Lỗi: '
             . $mail->ErrorInfo;

    }
}

?>