<?php
/**
 * Contact Us messages - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$db = getDB();
$result = $db->query("SELECT * FROM contactus ORDER BY id DESC");
$messages = $result->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Contact Messages';
$currentPage = 'contact';
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<div class="container-fluid mt-4">
    <h1 class="mb-4"><i class="fas fa-envelope"></i> Contact Messages</h1>
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($messages)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No messages found.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
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
                                    <td><?php echo SecurityHelper::escape($msg['name']); ?></td>
                                    <td><?php echo SecurityHelper::escape($msg['email']); ?></td>
                                    <td><?php echo SecurityHelper::escape($msg['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo SecurityHelper::escape(substr($msg['message'], 0, 50)); ?>...</td>
                                    <td><?php echo $msg['created_at'] ?? 'N/A'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
