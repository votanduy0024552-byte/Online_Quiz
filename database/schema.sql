-- Database Schema for MyExam Mobile LMS
-- Created: 2025-04-16

CREATE DATABASE IF NOT EXISTS myexam_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myexam_db;

-- 1. USERS table
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
    INDEX (username, email, role, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. KHOI_LOP table
CREATE TABLE IF NOT EXISTS khoi_lop (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_khoi VARCHAR(50) NOT NULL,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. MON_HOC table
CREATE TABLE IF NOT EXISTS mon_hoc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_mon VARCHAR(100) NOT NULL,
    khoi_id INT NOT NULL,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. CHU_DE table
CREATE TABLE IF NOT EXISTS chu_de (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_chu_de VARCHAR(100) NOT NULL,
    mon_id INT NOT NULL,
    khoi_id INT NOT NULL,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mon_id) REFERENCES mon_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. LOP_HOC table
CREATE TABLE IF NOT EXISTS lop_hoc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_lop VARCHAR(50) NOT NULL,
    khoi_id INT NOT NULL,
    giao_vien_chu_nhiem_id INT,
    nam_hoc VARCHAR(10),
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    FOREIGN KEY (giao_vien_chu_nhiem_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Continue with more tables...
-- (Full schema with 19 tables)

INSERT INTO users (username, password, full_name, email, phone, role, status) VALUES
('admin', '\\\...', 'Admin', 'admin@example.com', '0123456789', 'Admin', 'Active'),
('teacher', '\\\...', 'Giáo viên', 'teacher@example.com', '0123456789', 'Giáo viên', 'Active'),
('student', '\\\...', 'Học sinh', 'student@example.com', '0123456789', 'Học sinh', 'Active');
