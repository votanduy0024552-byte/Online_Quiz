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
-- TABLE 2: KHOI_LOP (Grade Levels)
-- ============================================================
CREATE TABLE IF NOT EXISTS khoi_lop (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_khoi VARCHAR(50) NOT NULL UNIQUE,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ten_khoi (ten_khoi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 3: MON_HOC (Subjects)
-- ============================================================
CREATE TABLE IF NOT EXISTS mon_hoc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_mon VARCHAR(100) NOT NULL,
    khoi_id INT NOT NULL,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    UNIQUE KEY unique_mon_khoi (ten_mon, khoi_id),
    INDEX idx_khoi_id (khoi_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 4: CHU_DE (Topics/Chapters)
-- ============================================================
CREATE TABLE IF NOT EXISTS chu_de (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_chu_de VARCHAR(100) NOT NULL,
    mon_id INT NOT NULL,
    khoi_id INT NOT NULL,
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mon_id) REFERENCES mon_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    UNIQUE KEY unique_chude_mon (ten_chu_de, mon_id),
    INDEX idx_mon_id (mon_id),
    INDEX idx_khoi_id (khoi_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 5: LOP_HOC (Classes)
-- ============================================================
CREATE TABLE IF NOT EXISTS lop_hoc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_lop VARCHAR(50) NOT NULL UNIQUE,
    khoi_id INT NOT NULL,
    giao_vien_chu_nhiem_id INT,
    nam_hoc VARCHAR(10),
    mo_ta TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    FOREIGN KEY (giao_vien_chu_nhiem_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_khoi_id (khoi_id),
    INDEX idx_giao_vien_id (giao_vien_chu_nhiem_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 6: QUESTIONS (Question Bank - D1, D2, D3)
-- ============================================================
CREATE TABLE IF NOT EXISTS questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('D1', 'D2', 'D3') NOT NULL,
    khoi_id INT NOT NULL,
    mon_id INT NOT NULL,
    chu_de_id INT,
    title LONGTEXT NOT NULL,
    description LONGTEXT,
    image_url VARCHAR(500),
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    FOREIGN KEY (mon_id) REFERENCES mon_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (chu_de_id) REFERENCES chu_de(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_type (type),
    INDEX idx_khoi_id (khoi_id),
    INDEX idx_mon_id (mon_id),
    INDEX idx_chu_de_id (chu_de_id),
    FULLTEXT INDEX ft_title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 7: QUESTION_D1 (Multiple Choice Options)
-- ============================================================
CREATE TABLE IF NOT EXISTS question_d1 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL UNIQUE,
    option_a VARCHAR(500) NOT NULL,
    option_b VARCHAR(500) NOT NULL,
    option_c VARCHAR(500) NOT NULL,
    option_d VARCHAR(500) NOT NULL,
    correct_answer ENUM('A', 'B', 'C', 'D') NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 8: QUESTION_D2 (True/False - 4 Statements)
-- ============================================================
CREATE TABLE IF NOT EXISTS question_d2 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL UNIQUE,
    statement_1 VARCHAR(500) NOT NULL,
    statement_2 VARCHAR(500) NOT NULL,
    statement_3 VARCHAR(500) NOT NULL,
    statement_4 VARCHAR(500) NOT NULL,
    correct_answer VARCHAR(4) NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 9: QUESTION_D3 (Short Answer)
-- ============================================================
CREATE TABLE IF NOT EXISTS question_d3 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL UNIQUE,
    answer_type ENUM('text', 'blank') NOT NULL,
    answer_1 VARCHAR(500),
    answer_2 VARCHAR(500),
    answer_3 VARCHAR(500),
    answer_4 VARCHAR(500),
    num_blanks INT DEFAULT 1,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 10: EXAMS (Exam Master)
-- ============================================================
CREATE TABLE IF NOT EXISTS exams (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description LONGTEXT,
    password VARCHAR(255),
    duration INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    condition ENUM('ALL', 'GRADE_10', 'GRADE_11', 'GRADE_12', 'SPECIFIC_CLASS') DEFAULT 'ALL',
    specific_class_id INT,
    status ENUM('DRAFT', 'OPEN', 'CLOSED') DEFAULT 'DRAFT',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (specific_class_id) REFERENCES lop_hoc(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_start_time (start_time),
    INDEX idx_end_time (end_time),
    INDEX idx_created_by (created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 11: EXAM_DETAILS (Questions in Each Exam)
-- ============================================================
CREATE TABLE IF NOT EXISTS exam_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    exam_id INT NOT NULL,
    question_id INT NOT NULL,
    question_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_exam_question (exam_id, question_id),
    INDEX idx_exam_id (exam_id),
    INDEX idx_question_id (question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 12: EXAM_SUBMISSIONS (Student Exam Attempts)
-- ============================================================
CREATE TABLE IF NOT EXISTS exam_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    exam_id INT NOT NULL,
    student_id INT NOT NULL,
    status ENUM('IN_PROGRESS', 'SUBMITTED', 'TIMEOUT') DEFAULT 'IN_PROGRESS',
    start_time DATETIME NOT NULL,
    submit_time DATETIME,
    d1_score FLOAT DEFAULT 0,
    d2_score FLOAT DEFAULT 0,
    d3_score FLOAT DEFAULT 0,
    total_score FLOAT DEFAULT 0,
    percentage FLOAT DEFAULT 0,
    grade VARCHAR(2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_student_exam (exam_id, student_id),
    INDEX idx_exam_id (exam_id),
    INDEX idx_student_id (student_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 13: EXAM_ANSWERS (Student Answers)
-- ============================================================
CREATE TABLE IF NOT EXISTS exam_answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL,
    question_id INT NOT NULL,
    student_answer VARCHAR(500),
    is_correct BOOLEAN DEFAULT FALSE,
    question_score FLOAT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (submission_id) REFERENCES exam_submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    UNIQUE KEY unique_submission_question (submission_id, question_id),
    INDEX idx_submission_id (submission_id),
    INDEX idx_question_id (question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 14: ATTENDANCE_SCHEDULES (Điểm Danh Lịch)
-- ============================================================
CREATE TABLE IF NOT EXISTS attendance_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    class_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    start_time TIME NOT NULL,
    description VARCHAR(255),
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES lop_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_class_date (class_id, attendance_date),
    INDEX idx_class_id (class_id),
    INDEX idx_attendance_date (attendance_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 15: ATTENDANCE (Điểm Danh Chi Tiết)
-- ============================================================
CREATE TABLE IF NOT EXISTS attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    schedule_id INT NOT NULL,
    student_id INT NOT NULL,
    status ENUM('PRESENT', 'ABSENT', 'LATE', 'EXCUSED') DEFAULT 'ABSENT',
    marked_time DATETIME,
    marked_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (schedule_id) REFERENCES attendance_schedules(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (marked_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_schedule_student (schedule_id, student_id),
    INDEX idx_schedule_id (schedule_id),
    INDEX idx_student_id (student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 16: LEAVE_REQUESTS (Đơn Xin Nghỉ)
-- ============================================================
CREATE TABLE IF NOT EXISTS leave_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    class_id INT NOT NULL,
    leave_date DATE NOT NULL,
    reason LONGTEXT NOT NULL,
    status ENUM('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'PENDING',
    reviewed_by INT,
    reviewed_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES lop_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_student_id (student_id),
    INDEX idx_class_id (class_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 17: NOTIFICATIONS (Thông Báo)
-- ============================================================
CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('SCHOOL', 'CLASS', 'PERSONAL') DEFAULT 'PERSONAL',
    title VARCHAR(255) NOT NULL,
    message LONGTEXT NOT NULL,
    sender_id INT NOT NULL,
    recipient_id INT,
    class_id INT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES lop_hoc(id) ON DELETE CASCADE,
    INDEX idx_recipient_id (recipient_id),
    INDEX idx_class_id (class_id),
    INDEX idx_is_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 18: CLASS_STUDENTS (Lớp và Học Sinh)
-- ============================================================
CREATE TABLE IF NOT EXISTS class_students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    class_id INT NOT NULL,
    student_id INT NOT NULL,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES lop_hoc(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_class_student (class_id, student_id),
    INDEX idx_class_id (class_id),
    INDEX idx_student_id (student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE 19: TEACHER_PERMISSIONS (Quyền Giáo Viên)
-- ============================================================
CREATE TABLE IF NOT EXISTS teacher_permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT NOT NULL,
    khoi_id INT NOT NULL,
    mon_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (khoi_id) REFERENCES khoi_lop(id) ON DELETE CASCADE,
    FOREIGN KEY (mon_id) REFERENCES mon_hoc(id) ON DELETE CASCADE,
    UNIQUE KEY unique_teacher_khoi_mon (teacher_id, khoi_id, mon_id),
    INDEX idx_teacher_id (teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INSERT SEED DATA
-- ============================================================

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
