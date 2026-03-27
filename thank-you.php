<?php
$pageTitle = "Submitted | Feedback Portal";
include 'includes/header.php';
$tid = htmlspecialchars($_GET['tid'] ?? '');
?>

<section class="form-section">
    <div class="thankyou-box">
        <div class="icon"><i class="fas fa-check-circle"></i></div>
        <h2>Complaint Submitted Successfully!</h2>
        <p>Thank you for your feedback. Your complaint has been registered.</p>
        <p><strong>Your Tracking ID:</strong></p>
        <div class="tracking-id"><?= $tid ?></div>
        <p style="color:var(--gray); margin: 16px 0;">
            Save this ID. Use it to track your complaint status.
        </p>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-top:20px;">
            <a href="track.php" class="btn btn-primary">
                <i class="fas fa-search"></i> Track Status
            </a>
            <a href="submit.php" class="btn btn-info">
                <i class="fas fa-plus"></i> New Complaint
            </a>
            <a href="index.php" class="btn btn-outline" style="border-color:var(--primary); color:var(--primary);">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>