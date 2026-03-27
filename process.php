<?php
require_once 'config/database.php';
require_once 'config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: submit.php');
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email']     ?? '');
$phone     = trim($_POST['phone']     ?? '');
$category  = trim($_POST['category']  ?? '');
$subject   = trim($_POST['subject']   ?? '');
$message   = trim($_POST['message']   ?? '');
$priority  = trim($_POST['priority']  ?? 'medium');

// Validation
$errors = [];

if (empty($full_name) || strlen($full_name) < 3)
    $errors[] = "Full name is required (min 3 characters).";

// ===== API EMAIL VALIDATION =====
if (empty($email)) {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address format.";
} else {
    $emailCheck = validateEmailAPI($email);
    if (!$emailCheck['valid']) {
        $errors[] = $emailCheck['message'];
    }
}

if (empty($phone) || !preg_match('/^[0-9]{10,15}$/', $phone))
    $errors[] = "A valid phone number is required.";

if (empty($category))
    $errors[] = "Category is required.";

if (empty($subject) || strlen($subject) < 5)
    $errors[] = "Subject is required (min 5 characters).";

if (empty($message) || strlen($message) < 20)
    $errors[] = "Message must be at least 20 characters.";

if (!in_array($priority, ['low', 'medium', 'high']))
    $priority = 'medium';

if (!empty($errors)) {
    header("Location: submit.php?error=" . urlencode(implode(' ', $errors)));
    exit;
}

// File Upload
$attachmentName = null;

if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['attachment']['tmp_name'];
    $fileName    = $_FILES['attachment']['name'];
    $fileSize    = $_FILES['attachment']['size'];
    $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, ALLOWED_TYPES)) {
        header("Location: submit.php?error=" . urlencode("File type .$fileExt is not allowed."));
        exit;
    }

    if ($fileSize > MAX_FILE_SIZE) {
        header("Location: submit.php?error=" . urlencode("File exceeds 5 MB limit."));
        exit;
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    $newFileName = uniqid('file_', true) . '.' . $fileExt;
    $destPath    = UPLOAD_DIR . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $attachmentName = $newFileName;
    } else {
        header("Location: submit.php?error=" . urlencode("File upload failed."));
        exit;
    }
}

// Database Insert
$conn       = getDBConnection();
$trackingId = generateTrackingId();

$stmt = $conn->prepare(
    "INSERT INTO complaints 
        (tracking_id, full_name, email, phone, category, subject, message, priority, attachment)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param("sssssssss",
    $trackingId, $full_name, $email, $phone, $category,
    $subject, $message, $priority, $attachmentName
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    // ===== SEND CONFIRMATION EMAIL =====
    $emailResult = sendComplaintConfirmation(
        $email, 
        $full_name, 
        $trackingId, 
        $subject, 
        $category, 
        $priority,
        $message
    );

    // Redirect with email status
    $emailStatus = $emailResult['success'] ? '&email=sent' : '&email=failed';
    header("Location: thank-you.php?tid=" . urlencode($trackingId) . $emailStatus);
    exit;
} else {
    $stmt->close();
    $conn->close();
    header("Location: submit.php?error=" . urlencode("Database error. Please try again."));
    exit;
}
?>