<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getDBConnection();
$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM complaints WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header('Location: dashboard.php');
    exit;
}

$complaint = $result->fetch_assoc();
$stmt->close();
$conn->close();

$pageTitle = "View Complaint | FeedbackPro Admin";
$cssPath = "../css/style.css";
$basePath = "../";
include '../includes/header.php';
?>

<section class="form-section">
    <div class="view-container">

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Status updated successfully! Email notification sent to customer.
            </div>
            <script>
                setTimeout(() => {
                    if (typeof showToast === 'function') {
                        showToast('✅ Status updated & email sent!', 'success');
                    }
                }, 500);
            </script>
        <?php endif; ?>

        <div class="view-header">
            <a href="dashboard.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <span class="badge badge-<?= $complaint['status'] ?>" style="font-size:.85rem; padding:8px 20px;">
                <?= ucfirst(str_replace('_',' ',$complaint['status'])) ?>
            </span>
        </div>

        <h2 style="display:flex; align-items:center; gap:10px; margin-bottom:32px;">
            <i class="fas fa-clipboard-list" style="color:var(--primary);"></i>
            <?= htmlspecialchars($complaint['tracking_id']) ?>
        </h2>

        <div class="info-section">
            <h3><i class="fas fa-user"></i> Customer Information</h3>
            <div class="detail-grid">
                <div class="label">Full Name</div>
                <div><?= htmlspecialchars($complaint['full_name']) ?></div>
                <div class="label">Email</div>
                <div><?= htmlspecialchars($complaint['email']) ?></div>
                <div class="label">Phone</div>
                <div><?= htmlspecialchars($complaint['phone']) ?></div>
            </div>
        </div>

        <div class="info-section">
            <h3><i class="fas fa-info-circle"></i> Complaint Details</h3>
            <div class="detail-grid">
                <div class="label">Category</div>
                <div><?= ucfirst($complaint['category']) ?></div>
                <div class="label">Subject</div>
                <div><?= htmlspecialchars($complaint['subject']) ?></div>
                <div class="label">Priority</div>
                <div><span class="badge badge-<?= $complaint['priority'] ?>"><?= ucfirst($complaint['priority']) ?></span></div>
                <div class="label">Status</div>
                <div><span class="badge badge-<?= $complaint['status'] ?>"><?= ucfirst(str_replace('_',' ',$complaint['status'])) ?></span></div>
                <div class="label">Submitted</div>
                <div><?= date('M d, Y h:i A', strtotime($complaint['created_at'])) ?></div>
                <div class="label">Last Updated</div>
                <div><?= date('M d, Y h:i A', strtotime($complaint['updated_at'])) ?></div>
                <div class="label">Message</div>
                <div style="white-space:pre-wrap;"><?= htmlspecialchars($complaint['message']) ?></div>
            </div>
        </div>

        <?php if ($complaint['attachment']): ?>
        <div class="info-section">
            <h3><i class="fas fa-paperclip"></i> Attachment</h3>
            <a href="../uploads/<?= htmlspecialchars($complaint['attachment']) ?>" 
               target="_blank" class="btn btn-sm btn-info">
                <i class="fas fa-download"></i> <?= htmlspecialchars($complaint['attachment']) ?>
            </a>
        </div>
        <?php endif; ?>

        <?php if ($complaint['admin_remarks']): ?>
        <div class="info-section">
            <h3><i class="fas fa-comment-dots"></i> Previous Remarks</h3>
            <div class="alert alert-info">
                <i class="fas fa-quote-left"></i>
                <?= nl2br(htmlspecialchars($complaint['admin_remarks'])) ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="info-section">
            <h3><i class="fas fa-edit"></i> Update Status</h3>
            <form action="update-status.php" method="POST">
                <input type="hidden" name="id" value="<?= $complaint['id'] ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="status"><i class="fas fa-flag"></i> Status</label>
                        <select id="status" name="status" required>
                            <option value="pending" <?= $complaint['status']=='pending' ? 'selected' : '' ?>>⏳ Pending</option>
                            <option value="in_progress" <?= $complaint['status']=='in_progress' ? 'selected' : '' ?>>🔄 In Progress</option>
                            <option value="resolved" <?= $complaint['status']=='resolved' ? 'selected' : '' ?>>✅ Resolved</option>
                            <option value="closed" <?= $complaint['status']=='closed' ? 'selected' : '' ?>>🔒 Closed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="admin_remarks"><i class="fas fa-message"></i> Admin Remarks</label>
                    <textarea id="admin_remarks" name="admin_remarks" rows="4" 
                              placeholder="Add notes or remarks..."><?= htmlspecialchars($complaint['admin_remarks'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Update Complaint
                </button>
            </form>
        </div>

    </div>
</section>

<?php include '../includes/footer.php'; ?>