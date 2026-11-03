# Lab 7 - AJAX, PHP và MySQL

## Cài đặt

1. Khởi động Apache và MySQL trong XAMPP.
2. Mở phpMyAdmin, nhập và chạy `udn.sql`.
3. Nếu thông tin MySQL không phải `localhost` / `root` / mật khẩu trống, sửa `config/database.php`.
4. Tạo dữ liệu sinh viên mẫu từ PowerShell hoặc Command Prompt:

   ```powershell
   C:\xampp\php\php.exe C:\xampp\htdocs\Lab1\Lab7\setup_demo_data.php
   ```

   Tập lệnh chỉ chạy từ CLI và chỉ thêm mã sinh viên chưa tồn tại.

5. Mở từng bài qua Apache:
   - Bài 1: `http://localhost/Lab1/Lab7/bai1/`
   - Bài 2: `http://localhost/Lab1/Lab7/bai2/`
   - Bài 3: `http://localhost/Lab1/Lab7/bai3/`
   - Bài 4: `http://localhost/Lab1/Lab7/bai4/login.php`

Tài khoản mẫu của Bài 4: `SV001` / `Lab7demo!`.

## Nội dung

- **Bài 1:** Chọn lớp và tải danh sách sinh viên bằng AJAX.
- **Bài 2:** Lớp `Dao` truy vấn và hiển thị danh sách giáo viên, sinh viên hoặc học phần.
- **Bài 3:** Tìm kiếm gợi ý học phần theo tiền tố nhập vào.
- **Bài 4:** Đăng nhập AJAX, kiểm tra mật khẩu đã băm, lưu session và đăng xuất.

Các bài dùng chung kết nối PDO tại `config/database.php`; tạo sẵn các bảng và dữ liệu giáo viên/học phần trong `udn.sql`.
