<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'feedback_portal');

define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024);
define('ALLOWED_TYPES', ['pdf','jpg','jpeg','png','doc','docx']);

function getDBConnection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

function generateTrackingId(): string {
    return 'CMP-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
}
?>