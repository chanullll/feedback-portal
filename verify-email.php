<?php
header('Content-Type: application/json');

$email = trim($_GET['email'] ?? '');

if (empty($email)) {
    echo json_encode(['valid' => false, 'message' => 'Email required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['valid' => false, 'message' => 'Invalid email format']);
    exit;
}

require_once 'config/database.php';
require_once 'config/mail.php';

$result = validateEmailAPI($email);

// Fix float precision
if (isset($result['score'])) {
    $result['score'] = (float) number_format($result['score'], 2, '.', '');
}

echo json_encode($result);
?>
