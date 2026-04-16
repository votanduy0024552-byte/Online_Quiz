<?php
/**
 * Application Constants
 * Roles, Status, Question Types, etc.
 */

// ============ ROLES ============
const ROLE_ADMIN = 'Admin';
const ROLE_TEACHER = 'Giáo viên';
const ROLE_STUDENT = 'Học sinh';
const ROLES = [ROLE_ADMIN, ROLE_TEACHER, ROLE_STUDENT];

// ============ USER STATUS ============
const STATUS_ACTIVE = 'Active';
const STATUS_PENDING = 'Pending';
const STATUS_INACTIVE = 'Inactive';
const USER_STATUSES = [STATUS_ACTIVE, STATUS_PENDING, STATUS_INACTIVE];

// ============ QUESTION TYPES ============
const QUESTION_TYPE_D1 = 'D1'; // Multiple choice (4 options)
const QUESTION_TYPE_D2 = 'D2'; // True/False (4 statements)
const QUESTION_TYPE_D3 = 'D3'; // Short answer (1 or 4 blanks)
const QUESTION_TYPES = [QUESTION_TYPE_D1, QUESTION_TYPE_D2, QUESTION_TYPE_D3];

// ============ EXAM STATUS ============
const EXAM_STATUS_DRAFT = 'Chưa mở';
const EXAM_STATUS_OPEN = 'Đang mở';
const EXAM_STATUS_CLOSED = 'Đã đóng';
const EXAM_STATUSES = [EXAM_STATUS_DRAFT, EXAM_STATUS_OPEN, EXAM_STATUS_CLOSED];

// ============ EXAM SUBMISSION STATUS ============
const SUBMISSION_STATUS_IN_PROGRESS = 'Đang làm';
const SUBMISSION_STATUS_SUBMITTED = 'Đã nộp';
const SUBMISSION_STATUS_TIMEOUT = 'Hết giờ';
const SUBMISSION_STATUSES = [SUBMISSION_STATUS_IN_PROGRESS, SUBMISSION_STATUS_SUBMITTED, SUBMISSION_STATUS_TIMEOUT];

// ============ ATTENDANCE STATUS ============
const ATTENDANCE_PRESENT = 'Có mặt';
const ATTENDANCE_ABSENT = 'Vắng';
const ATTENDANCE_LATE = 'Muộn';
const ATTENDANCE_EXCUSED = 'Có phép';
const ATTENDANCE_STATUSES = [ATTENDANCE_PRESENT, ATTENDANCE_ABSENT, ATTENDANCE_LATE, ATTENDANCE_EXCUSED];

// ============ LEAVE REQUEST STATUS ============
const LEAVE_STATUS_PENDING = 'Chờ duyệt';
const LEAVE_STATUS_APPROVED = 'Đã duyệt';
const LEAVE_STATUS_REJECTED = 'Từ chối';
const LEAVE_STATUSES = [LEAVE_STATUS_PENDING, LEAVE_STATUS_APPROVED, LEAVE_STATUS_REJECTED];

// ============ NOTIFICATION TYPE ============
const NOTIFICATION_TYPE_SCHOOL = 'Toàn trường';
const NOTIFICATION_TYPE_CLASS = 'Lớp cụ thể';
const NOTIFICATION_TYPE_PERSONAL = 'Cá nhân';
const NOTIFICATION_TYPES = [NOTIFICATION_TYPE_SCHOOL, NOTIFICATION_TYPE_CLASS, NOTIFICATION_TYPE_PERSONAL];

// ============ EXAM CONDITIONS ============
const EXAM_CONDITION_ALL = 'Tất cả';
const EXAM_CONDITION_GRADE_10 = 'Khối 10';
const EXAM_CONDITION_GRADE_11 = 'Khối 11';
const EXAM_CONDITION_GRADE_12 = 'Khối 12';
const EXAM_CONDITION_SPECIFIC_CLASS = 'Lớp cụ thể';
const EXAM_CONDITIONS = [
    EXAM_CONDITION_ALL,
    EXAM_CONDITION_GRADE_10,
    EXAM_CONDITION_GRADE_11,
    EXAM_CONDITION_GRADE_12,
    EXAM_CONDITION_SPECIFIC_CLASS
];

// ============ SCORING SETTINGS ============
const SCORE_D1_PER_QUESTION = 1.0;
const SCORE_D2_PER_QUESTION = 1.0;
const SCORE_D3_PER_QUESTION = 1.0;

// D2 Partial Credit
const D2_CREDIT_1_OF_4 = 0.1;  // 10%
const D2_CREDIT_2_OF_4 = 0.25; // 25%
const D2_CREDIT_3_OF_4 = 0.5;  // 50%
const D2_CREDIT_4_OF_4 = 1.0;  // 100%

// ============ VALIDATION RULES ============
const USERNAME_MIN_LENGTH = 3;
const USERNAME_MAX_LENGTH = 50;
const PASSWORD_MIN_LENGTH = 6;
const PASSWORD_MAX_LENGTH = 255;
const PHONE_REGEX = '/^0[0-9]{9}$/'; // Vietnamese phone
const CCCD_REGEX = '/^[0-9]{9,12}$/'; // ID Card
const EMAIL_REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

// ============ RESPONSE CODES ============
const HTTP_OK = 200;
const HTTP_CREATED = 201;
const HTTP_BAD_REQUEST = 400;
const HTTP_UNAUTHORIZED = 401;
const HTTP_FORBIDDEN = 403;
const HTTP_NOT_FOUND = 404;
const HTTP_CONFLICT = 409;
const HTTP_INTERNAL_ERROR = 500;

// ============ ERROR MESSAGES ============
const ERROR_INVALID_REQUEST = 'Yêu cầu không hợp lệ';
const ERROR_UNAUTHORIZED = 'Bạn cần đăng nhập';
const ERROR_FORBIDDEN = 'Bạn không có quyền truy cập';
const ERROR_NOT_FOUND = 'Dữ liệu không tìm thấy';
const ERROR_DATABASE = 'Lỗi cơ sở dữ liệu';
const ERROR_SERVER = 'Lỗi máy chủ';

// ============ SUCCESS MESSAGES ============
const SUCCESS_LOGIN = 'Đăng nhập thành công';
const SUCCESS_REGISTER = 'Đăng ký thành công';
const SUCCESS_UPDATE = 'Cập nhật thành công';
const SUCCESS_DELETE = 'Xóa thành công';
const SUCCESS_CREATE = 'Tạo mới thành công';

?>
