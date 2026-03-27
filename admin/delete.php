<?php
require_once 'auth.php';
require_once '../config/database.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $conn = getDBConnection();

    $stmt = $conn->prepare("SELECT attachment FROM complaints WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if ($row['attachment'] && file_exists(UPLOAD_DIR . $row['attachment'])) {
            unlink(UPLOAD_DIR . $row['attachment']);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM complaints WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

header('Location: dashboard.php');
exit;
?>