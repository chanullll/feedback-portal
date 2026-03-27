<?php
$pageTitle = "Tracking Result | Feedback Portal";
require_once 'config/database.php';
include 'includes/header.php';

$tid    = trim($_GET['tid'] ?? '');
$result = null;

if (!empty($tid)) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM complaints WHERE tracking_id = ?");
    $stmt->bind_param("s", $tid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $result = $res->fetch_assoc();
    }
    $stmt->close();
    $conn->close();
}
?>

<section class="form-section">
    <?php if ($result): ?>
        <div class="track-result">
            <h2><i class="fas fa-clipboard-list"></i> Complaint Details</h2>
            <div class="detail-grid">
                <div class="label">Tracking ID</div>
                <div><strong><?= htmlspecialchars($result['tracking_id']) ?></strong></div>
                <div class="label">Name</div>
                <div><?= htmlspecialchars($result['full_name']) ?></div>
                <div class="label">Email</div>
                <div><?= htmlspecialchars($result['email']) ?></div>
                <div class="label">Phone</div>
                <div><?= htmlspecialchars($result['phone']) ?></div>
                <div class="label">Category</div>
                <div><?= ucfirst(htmlspecialchars($result['category'])) ?></div>
                <div class="label">Subject</div>
                <div><?= htmlspecialchars($result['subject']) ?></div>
                <div class="label">Priority</div>
                <div>
                    <span class="badge badge-<?= $result['priority'] ?>">
                        <?= ucfirst($result['priority']) ?>
                    </span>
                </div>
                <div class="label">Status</div>
                <div>
                    <span class="badge badge-<?= $result['status'] ?>">
                        <?= ucfirst(str_replace('_', ' ', $result['status'])) ?>
                    </span>
                </div>
                <div class="label">Submitted On</div>
                <div><?= date('M d, Y h:i A', strtotime($result['created_at'])) ?></div>
                <div class="label">Last Updated</div>
                <div><?= date('M d, Y h:i A', strtotime($result['updated_at'])) ?></div>
                <?php if ($result['admin_remarks']): ?>
                    <div class="label">Admin Remarks</div>
                    <div><?= nl2br(htmlspecialchars($result['admin_remarks'])) ?></div>
                <?php endif; ?>
                <div class="label">Message</div>
                <div><?= nl2br(htmlspecialchars($result['message'])) ?></div>
                <?php if ($result['attachment']): ?>
                    <div class="label">Attachment</div>
                    <div>
                        <a href="uploads/<?= htmlspecialchars($result['attachment']) ?>" 
                           target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-download"></i> View File
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="track-container">
            <div style="font-size:3rem; color:var(--danger); margin-bottom:16px;">
                <i class="fas fa-times-circle"></i>
            </div>
            <h2>No Complaint Found</h2>
            <p style="color:var(--gray); margin:16px 0;">
                No record found for: <strong><?= htmlspecialchars($tid) ?></strong>
            </p>
            <a href="track.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Try Again
            </a>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>