-- Tạo bảng lưu danh sách email cho Bài 3
CREATE DATABASE IF NOT EXISTS lab8_email;
USE lab8_email;

CREATE TABLE IF NOT EXISTS contacts (
    contactID   INT NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (contactID)
);

-- Dữ liệu mẫu
INSERT IGNORE INTO contacts (name, email) VALUES
('Nguyen Van A', 'nguyenvana@example.com'),
('Tran Thi B', 'tranthib@example.com'),
('Le Van C', 'levanc@example.com'),
('Pham Thi D', 'phamthid@example.com');
