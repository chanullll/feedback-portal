<?php
require_once 'auth.php';
require_once '../config/database.php';
require_once '../config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$id      = intval($_POST['id'] ?? 0);
$status  = trim($_POST['status'] ?? '');
$remarks = trim($_POST['admin_remarks'] ?? '');

$validStatuses = ['pending', 'in_progress', 'resolved', 'closed'];

if ($id <= 0 || !in_array($status, $validStatuses)) {
    header('Location: dashboard.php');
    exit;
}

$conn = getDBConnection();

// Get complaint details BEFORE update
$stmt = $conn->prepare("SELECT email, full_name, tracking_id, status, subject FROM complaints WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$complaint = $result->fetch_assoc();
$stmt->close();

if (!$complaint) {
    $conn->close();
    header('Location: dashboard.php');
    exit;
}

$oldStatus = $complaint['status'];

// Update in database
$stmt = $conn->prepare("UPDATE complaints SET status = ?, admin_remarks = ? WHERE id = ?");
$stmt->bind_param("ssi", $status, $remarks, $id);
$stmt->execute();
$stmt->close();
$conn->close();

// Send email ONLY if status changed
$emailSent = false;
if ($oldStatus !== $status) {
    $emailResult = sendStatusUpdate(
        $complaint['email'],
        $complaint['full_name'],
        $complaint['tracking_id'],
        $oldStatus,
        $status,
        $remarks,
        $complaint['subject']
    );
    $emailSent = $emailResult['success'];
}

$emailParam = $emailSent ? '&email=sent' : '&email=not_sent';
header("Location: view.php?id=$id&updated=1" . $emailParam);
exit;
?>
