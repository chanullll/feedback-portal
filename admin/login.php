<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $admin = $res->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'Admin user not found.';
        }
        $stmt->close();
        $conn->close();
    }
}

$pageTitle = "Admin Login | FeedbackPro";
$cssPath   = "../css/style.css";
$basePath  = "../";
include '../includes/header.php';
?>

<section class="form-section">
    <div class="login-container">
        <div class="login-header">
            <div class="login-avatar">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h2>Admin Login</h2>
            <p>Sign in to manage complaints</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center;">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
    </div>
</section>

<?php include '../includes/footer.php'; ?>