# MyExam Mobile - Learning Management System

Hệ thống quản lý học tập toàn diện cho trường học, hỗ trợ các kỳ thi trắc nghiệm theo cấu trúc 2025.

## 🎯 Tính Năng Chính

### Học Sinh
- ✅ Vào thi trắc nghiệm (D1, D2, D3)
- ✅ Xin phép nghỉ học
- ✅ Xem bảng xếp hạng
- ✅ Nhận thông báo

### Giáo Viên
- ✅ Quản lý lớp học
- ✅ Duyệt học sinh mới
- ✅ Quản lý ngân hàng câu hỏi
- ✅ Soạn đề thi
- ✅ Điểm danh
- ✅ Duyệt đơn xin nghỉ
- ✅ Gửi thông báo

### Admin
- ✅ Quản lý tài khoản (User)
- ✅ Quản lý kỳ thi (Master)
- ✅ Phân quyền giáo viên
- ✅ Quản lý lớp học
- ✅ Quản lý chủ đề bài học
- ✅ Gửi thông báo toàn trường

## 🛠️ Công Nghệ Sử Dụng

- **Backend:** PHP 7.4+ (MVC Architecture)
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Database:** MySQL 5.7+
- **Server:** Apache 2.4+

## 📊 Cấu Trúc Dự Án

\\\
Online_Quiz/
├── config/              # Cấu hình ứng dụng
├── api/                 # API endpoints
├── models/              # Business logic
├── controllers/         # Request handlers
├── views/               # HTML templates
├── public/              # Static assets (CSS, JS)
├── utils/               # Helper functions
├── logs/                # Application logs
├── database/            # Database schema & migrations
├── .htaccess           # Apache routing
├── index.php           # Entry point
└── README.md           # Documentation
\\\

## 📥 Cài Đặt

### Yêu Cầu
- PHP 7.4+
- MySQL 5.7+
- Apache 2.4+ (hoặc web server hỗ trợ .htaccess)

### Các Bước

1. **Clone Repository**
\\\ash
git clone https://github.com/votanduy0024552-byte/Online_Quiz.git
cd Online_Quiz
\\\

2. **Tạo Database**
\\\ash
mysql -u root -p < database/schema.sql
\\\

3. **Cấu Hình Database**
- Sửa file \config/config.php\
- Điền thông tin: DB_HOST, DB_USER, DB_PASS, DB_NAME

4. **Run Web Server**
\\\ash
php -S localhost:8000
\\\

5. **Truy Cập**
- Mở trình duyệt: http://localhost:8000
- Đăng nhập với tài khoản Admin (mặc định)

## 📝 Default Accounts

| Role | Username | Password | Email |
|------|----------|----------|-------|
| Admin | admin | admin123 | admin@example.com |
| Teacher | teacher | teacher123 | teacher@example.com |
| Student | student | student123 | student@example.com |

## 🔐 Security

- Password hashing: bcrypt
- SQL Injection protection: Prepared statements
- XSS protection: Input sanitization
- CSRF protection: Token validation
- Session timeout: 1 hour

## 📚 API Documentation

### Authentication
- POST /api/auth/login
- POST /api/auth/register
- POST /api/auth/logout
- POST /api/auth/reset-password

### Users
- GET /api/users/:id
- PUT /api/users/:id
- DELETE /api/users/:id

### Exams
- GET /api/exams
- POST /api/exams
- GET /api/exams/:id
- PUT /api/exams/:id
- DELETE /api/exams/:id

### Questions
- GET /api/questions
- POST /api/questions
- GET /api/questions/:id
- PUT /api/questions/:id
- DELETE /api/questions/:id

### Submissions
- POST /api/submissions (submit exam)
- GET /api/submissions/:id (get results)

## 👨‍💼 Tác Giả

**votanduy0024552-byte**

## 📄 License

MIT License - Tự do sử dụng cho mục đích học tập và thương mại

## 🤝 Đóng Góp

Mọi đóng góp đều được hoan nghênh! Vui lòng:
1. Fork repository
2. Tạo branch feature: \git checkout -b feature/amazing-feature\
3. Commit changes: \git commit -m 'Add amazing feature'\
4. Push to branch: \git push origin feature/amazing-feature\
5. Open Pull Request

## 📞 Liên Hệ

- Email: votanduy0024552@gmail.com
- GitHub: https://github.com/votanduy0024552-byte
- Website: https://github.com/votanduy0024552-byte/Online_Quiz

---

**Happy Learning! 🎓**
