<?php
/**
 * Helper Functions
 * 
 * Common utility functions
 */

/**
 * Sanitize input
 */
function sanitize(\) {
    return htmlspecialchars(trim(\), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function isValidEmail(\) {
    return filter_var(\, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone (Vietnam)
 */
function isValidPhone(\) {
    return preg_match(PHONE_REGEX, \) === 1;
}

/**
 * Validate CCCD
 */
function isValidCCCD(\) {
    return preg_match(CCCD_REGEX, \) === 1;
}

/**
 * Get current timestamp
 */
function getCurrentTimestamp() {
    return date('Y-m-d H:i:s');
}

/**
 * Generate random token
 */
function generateToken(\ = 32) {
    return bin2hex(random_bytes(\ / 2));
}

/**
 * Log message
 */
function logMessage(\, \ = 'INFO') {
    \ = date('Y-m-d H:i:s');
    \ = LOGS_DIR . '/app.log';
    \ = "[\] [\] \" . PHP_EOL;
    file_put_contents(\, \, FILE_APPEND);
}

/**
 * Log error
 */
function logError(\A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'.) {
    \ = date('Y-m-d H:i:s');
    \ = LOGS_DIR . '/error.log';
    \ = "[\] [ERROR] \A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'. A parameter cannot be found that matches parameter name 'Chord'." . PHP_EOL;
    file_put_contents(\, \, FILE_APPEND);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset(\['user_id']);
}

/**
 * Get current user
 */
function getCurrentUser() {
    return \['user'] ?? null;
}

/**
 * Check user role
 */
function hasRole(\) {
    return isset(\['role']) && \['role'] === \;
}

/**
 * Redirect
 */
function redirect(\) {
    header('Location: ' . APP_URL . \);
    exit;
}

?>
