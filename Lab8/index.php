<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Gửi Email</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">

    <h2>Email tới bạn</h2>

    <form action="mail.php"
          enctype="multipart/form-data"
          method="POST">

        <div class="mb-3">
            <label>Email người nhận</label>

            <input type="email"
                   class="form-control"
                   name="email"
                   placeholder="Email"
                   required>
        </div>

        <div class="mb-3">
            <label>Tiêu đề</label>

            <input type="text"
                   class="form-control"
                   name="tieude"
                   placeholder="Tiêu đề"
                   required>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>

            <textarea name="content"
                      id="editor"
                      class="form-control"
                      rows="6"></textarea>
        </div>

        <div class="mb-3">
            <label>File đính kèm</label>

            <input type="file"
                   class="form-control"
                   name="file">
        </div>

        <button type="submit"
                class="btn btn-primary">
            Gửi
        </button>

    </form>

</div>

</body>
</html>