<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getDBConnection();

$total    = $conn->query("SELECT COUNT(*) as c FROM complaints")->fetch_assoc()['c'];
$pending  = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='pending'")->fetch_assoc()['c'];
$prog     = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='in_progress'")->fetch_assoc()['c'];
$resolved = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='resolved'")->fetch_assoc()['c'];
$closed   = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='closed'")->fetch_assoc()['c'];

$statusFilter = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

$where = 'WHERE 1=1';
if (in_array($statusFilter, ['pending','in_progress','resolved','closed'])) {
    $where .= " AND status = '" . $conn->real_escape_string($statusFilter) . "'";
}
if (!empty($search)) {
    $s = $conn->real_escape_string($search);
    $where .= " AND (tracking_id LIKE '%$s%' OR full_name LIKE '%$s%' OR email LIKE '%$s%')";
}

$complaints = $conn->query(
    "SELECT id, tracking_id, full_name, category, priority, status, created_at 
     FROM complaints $where ORDER BY created_at DESC"
);

$pageTitle = "Dashboard | FeedbackPro Admin";
$cssPath   = "../css/style.css";
$basePath  = "../";
include '../includes/header.php';
?>

<section class="dashboard">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header">
            <h2><i class="fas fa-chart-line"></i> Dashboard</h2>
            <div class="admin-info">
                <div>
                    <div class="admin-name"><?= htmlspecialchars($_SESSION['admin_name']) ?></div>
                    <div class="admin-role">Administrator</div>
                </div>
                <div class="admin-avatar">
                    <?= strtoupper(substr($_SESSION['admin_name'], 0, 2)) ?>
                </div>
                <a href="logout.php" class="btn btn-sm btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-number"><?= $total ?></div>
                        <div class="stat-label">Total Complaints</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-inbox"></i></div>
                </div>
            </div>
            <div class="stat-card pending">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-number"><?= $pending ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                </div>
            </div>
            <div class="stat-card progress">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-number"><?= $prog ?></div>
                        <div class="stat-label">In Progress</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                </div>
            </div>
            <div class="stat-card resolved">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-number"><?= $resolved ?></div>
                        <div class="stat-label">Resolved</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="stat-card closed">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-number"><?= $closed ?></div>
                        <div class="stat-label">Closed</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-lock"></i></div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <form method="GET" style="width:100%;">
                <?php if ($statusFilter): ?>
                    <input type="hidden" name="status" value="<?= $statusFilter ?>">
                <?php endif; ?>
                <input type="text" name="search" placeholder="Search by name, email or tracking ID..." 
                       value="<?= htmlspecialchars($search) ?>">
            </form>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="dashboard.php" class="filter-tab <?= !$statusFilter ? 'active' : '' ?>">
                All (<?= $total ?>)
            </a>
            <a href="dashboard.php?status=pending" class="filter-tab <?= $statusFilter=='pending' ? 'active' : '' ?>">
                ⏳ Pending (<?= $pending ?>)
            </a>
            <a href="dashboard.php?status=in_progress" class="filter-tab <?= $statusFilter=='in_progress' ? 'active' : '' ?>">
                🔄 In Progress (<?= $prog ?>)
            </a>
            <a href="dashboard.php?status=resolved" class="filter-tab <?= $statusFilter=='resolved' ? 'active' : '' ?>">
                ✅ Resolved (<?= $resolved ?>)
            </a>
            <a href="dashboard.php?status=closed" class="filter-tab <?= $statusFilter=='closed' ? 'active' : '' ?>">
                🔒 Closed (<?= $closed ?>)
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Recent Complaints</h3>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tracking ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($complaints->num_rows > 0): ?>
                            <?php $i = 1; while ($row = $complaints->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><strong style="color:var(--primary);"><?= htmlspecialchars($row['tracking_id']) ?></strong></td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= ucfirst($row['category']) ?></td>
                                <td><span class="badge badge-<?= $row['priority'] ?>"><?= ucfirst($row['priority']) ?></span></td>
                                <td><span class="badge badge-<?= $row['status'] ?>"><?= ucfirst(str_replace('_',' ',$row['status'])) ?></span></td>
                                <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                <td class="actions">
                                    <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-icon" 
                                       onclick="return confirm('Delete this complaint?');" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h3>No complaints found</h3>
                                        <p>No complaints match your current filter.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php $conn->close(); include '../includes/footer.php'; ?>