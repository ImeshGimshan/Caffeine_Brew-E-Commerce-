<?php
/**
 * Contact Us messages - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$db = getDB();
$result = $db->query("SELECT * FROM contactus ORDER BY id DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Contact Messages';
$currentPage = 'contact';
$customCSS = ['admin.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-envelope me-2"></i> Contact Messages</h1>
    <div class="admin-header-actions">
        <span style="color:var(--medium-brown);font-size:0.9rem;">
            <i class="fas fa-info-circle me-1"></i> <?php echo count($messages); ?> messages received
        </span>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-inbox me-2" style="color:var(--gold-accent);"></i> All Messages
            <span class="badge ms-2" style="background:var(--primary-brown);font-size:0.8rem;"><?php echo count($messages); ?></span>
        </h2>
    </div>

    <?php if (empty($messages)): ?>
        <div class="text-center py-5" style="color:var(--medium-brown);">
            <i class="fas fa-inbox fa-3x mb-3" style="opacity:0.4;"></i>
            <p>No messages found.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo $msg['id']; ?></td>
                            <td><strong><?php echo SecurityHelper::escape($msg['name']); ?></strong></td>
                            <td><?php echo SecurityHelper::escape($msg['email']); ?></td>
                            <td><?php echo SecurityHelper::escape($msg['phone'] ?? 'N/A'); ?></td>
                            <td style="max-width:250px;color:var(--medium-brown);">
                                <?php echo SecurityHelper::escape(substr($msg['message'], 0, 80)); ?><?php echo strlen($msg['message']) > 80 ? '…' : ''; ?>
                            </td>
                            <td><?php echo $msg['created_at'] ? date('d M Y', strtotime($msg['created_at'])) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>
