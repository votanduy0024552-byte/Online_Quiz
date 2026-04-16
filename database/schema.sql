-- ============================================================
-- MyExam Mobile LMS - Database Schema
-- Version: 1.0
-- Created: 2025-04-16
-- ============================================================

CREATE DATABASE IF NOT EXISTS myexam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myexam_db;

-- ============================================================
-- TABLE 1: USERS
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    cccd VARCHAR(20) UNIQUE,
    avatar_url VARCHAR(500),
    date_of_birth DATE,
    gender ENUM('Nam', 'Nữ', 'Khác'),
    role ENUM('Admin', 'Giáo viên', 'Học sinh') DEFAULT 'Học sinh',
    status ENUM('Active', 'Pending', 'Inactive') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 2-19: (Copy từ file cũ, chỉ fix phần INSERT)
-- ============================================================

-- INSERT SEED DATA (FIX: Use proper bcrypt hashes for demo passwords)
-- Password hashes for: admin123, teacher123, student123

-- Khối lớp
INSERT INTO khoi_lop (ten_khoi, mo_ta) VALUES
('Khối 10', 'Lớp 10'),
('Khối 11', 'Lớp 11'),
('Khối 12', 'Lớp 12');

-- Môn học
INSERT INTO mon_hoc (ten_mon, khoi_id, mo_ta) VALUES
('Toán', 1, 'Môn Toán Khối 10'),
('Toán', 2, 'Môn Toán Khối 11'),
('Toán', 3, 'Môn Toán Khối 12'),
('Vật Lý', 1, 'Môn Vật Lý Khối 10'),
('Vật Lý', 2, 'Môn Vật Lý Khối 11'),
('Vật Lý', 3, 'Môn Vật Lý Khối 12'),
('Hóa Học', 1, 'Môn Hóa Học Khối 10'),
('Hóa Học', 2, 'Môn Hóa Học Khối 11'),
('Hóa Học', 3, 'Môn Hóa Học Khối 12'),
('Tiếng Anh', 1, 'Môn Tiếng Anh Khối 10'),
('Tiếng Anh', 2, 'Môn Tiếng Anh Khối 11'),
('Tiếng Anh', 3, 'Môn Tiếng Anh Khối 12');

-- Chủ đề
INSERT INTO chu_de (ten_chu_de, mon_id, khoi_id, mo_ta) VALUES
('Phương trình bậc hai', 1, 1, 'Phương trình bậc hai Khối 10'),
('Hệ phương trình', 1, 1, 'Hệ phương trình Khối 10'),
('Lượng giác', 2, 2, 'Lượng giác Khối 11'),
('Đạo hàm', 3, 3, 'Đạo hàm Khối 12'),
('Tích phân', 3, 3, 'Tích phân Khối 12');

-- Users - Admin (password: admin123)
INSERT INTO users (username, password, full_name, email, phone, cccd, gender, role, status) VALUES
('admin', '\\\/TVm', 'Admin System', 'admin@example.com', '0123456789', '123456789', 'Nam', 'Admin', 'Active');

-- Users - Teachers (password: teacher123)
INSERT INTO users (username, password, full_name, email, phone, cccd, gender, role, status) VALUES
('teacher1', '\\\/TVm', 'Giáo Viên 1', 'teacher1@example.com', '0987654321', '987654321', 'Nam', 'Giáo viên', 'Active'),
('teacher2', '\\\/TVm', 'Giáo Viên 2', 'teacher2@example.com', '0912345678', '912345678', 'Nữ', 'Giáo viên', 'Active');

-- Users - Students (password: student123)
INSERT INTO users (username, password, full_name, email, phone, cccd, gender, role, status, date_of_birth) VALUES
('student1', '\\\/TVm', 'Học Sinh 1', 'student1@example.com', '0901234567', '901234567', 'Nam', 'Học sinh', 'Active', '2008-01-15'),
('student2', '\\\/TVm', 'Học Sinh 2', 'student2@example.com', '0902345678', '902345678', 'Nữ', 'Học sinh', 'Active', '2008-02-20'),
('student3', '\\\/TVm', 'Học Sinh 3', 'student3@example.com', '0903456789', '903456789', 'Nam', 'Học sinh', 'Pending', '2008-03-10');

-- Lớp học
INSERT INTO lop_hoc (ten_lop, khoi_id, giao_vien_chu_nhiem_id, nam_hoc, mo_ta) VALUES
('10A1', 1, 2, '2024-2025', 'Lớp 10A1'),
('11A1', 2, 2, '2024-2025', 'Lớp 11A1'),
('12A1', 3, 3, '2024-2025', 'Lớp 12A1');

-- Class Students
INSERT INTO class_students (class_id, student_id, enrolled_date) VALUES
(1, 4, NOW()),
(1, 5, NOW()),
(3, 6, NOW());

-- Teacher Permissions
INSERT INTO teacher_permissions (teacher_id, khoi_id, mon_id) VALUES
(2, 1, 1),
(2, 2, 2),
(2, 3, 3),
(3, 1, 4),
(3, 2, 5),
(3, 3, 6);
