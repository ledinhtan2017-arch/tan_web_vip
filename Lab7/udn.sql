CREATE DATABASE IF NOT EXISTS udn
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE udn;

CREATE TABLE IF NOT EXISTS sinhvien (
    masv VARCHAR(20) NOT NULL PRIMARY KEY,
    hoten VARCHAR(120) NOT NULL,
    diachi VARCHAR(255) NOT NULL DEFAULT '',
    lop VARCHAR(30) NOT NULL,
    matkhau VARCHAR(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS giaovien (
    magv VARCHAR(20) NOT NULL PRIMARY KEY,
    hoten VARCHAR(120) NOT NULL,
    diachi VARCHAR(255) NOT NULL DEFAULT '',
    email VARCHAR(120) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS hocphan (
    mahp VARCHAR(20) NOT NULL PRIMARY KEY,
    tenhp VARCHAR(160) NOT NULL,
    sotinchi TINYINT UNSIGNED NOT NULL DEFAULT 3
);

INSERT IGNORE INTO giaovien (magv, hoten, diachi, email) VALUES
    ('GV001', 'Nguyễn Văn An', 'Đà Nẵng', 'an@example.edu.vn'),
    ('GV002', 'Trần Thị Bình', 'Quảng Nam', 'binh@example.edu.vn');

INSERT IGNORE INTO hocphan (mahp, tenhp, sotinchi) VALUES
    ('HP001', 'Lập trình PHP', 3),
    ('HP002', 'Cơ sở dữ liệu', 3),
    ('HP003', 'Lập trình Java', 4),
    ('HP004', 'Phân tích thiết kế hệ thống', 3),
    ('HP005', 'Mạng máy tính', 3);
