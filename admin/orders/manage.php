<?php
/**
 * Manage Orders - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Order.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$orderModel = new Order();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $status  = SecurityHelper::sanitize($_POST['status']);
    $allowed = ['pending', 'processing', 'out_for_delivery', 'delivered', 'cancelled'];
    if (in_array($status, $allowed)) {
        $orderModel->updateStatus($orderId, $status);
        $_SESSION['success_message'] = "Order #$orderId status updated to " . ucfirst(str_replace('_', ' ', $status)) . ".";
    }
    header("Location: manage.php");
    exit();
}

$orders = $orderModel->getAll();

$successMessage = SessionHelper::get('success_message');
if ($successMessage) SessionHelper::remove('success_message');

$pageTitle  = 'Manage Orders';
$currentPage = 'orders';
$customCSS  = ['admin.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-shopping-bag me-2"></i> Manage Orders</h1>
    <div class="admin-header-actions">
        <span style="color:var(--medium-brown);font-size:0.9rem;">
            <i class="fas fa-info-circle me-1"></i> <?php echo count($orders); ?> total orders
        </span>
    </div>
</div>

<?php if ($successMessage): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $successMessage; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<?php
$counts = ['pending'=>0,'processing'=>0,'out_for_delivery'=>0,'delivered'=>0,'cancelled'=>0];
$revenue = 0;
foreach ($orders as $o) {
    $s = $o['status'] ?? 'pending';
    if (isset($counts[$s])) $counts[$s]++;
    if (in_array($s, ['delivered','completed'])) $revenue += floatval($o['total_amount']);
}
?>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:var(--dark-brown);"><?php echo count($orders); ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">All Orders</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;border-left:4px solid #F57F17;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:#F57F17;"><?php echo $counts['pending']; ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">Pending</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;border-left:4px solid #1565C0;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:#1565C0;"><?php echo $counts['processing']; ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">Processing</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;border-left:4px solid #7B1FA2;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:#7B1FA2;"><?php echo $counts['out_for_delivery']; ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">Out for Delivery</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;border-left:4px solid #2E7D32;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:#2E7D32;"><?php echo $counts['delivered']; ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">Delivered</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="content-section text-center py-3 px-2" style="margin-bottom:0;border-left:4px solid #C62828;">
            <div style="font-size:1.8rem;font-family:var(--font-heading);color:#C62828;"><?php echo $counts['cancelled']; ?></div>
            <div style="font-size:0.82rem;color:var(--medium-brown);">Cancelled</div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-list me-2" style="color:var(--gold-accent);"></i> All Orders</h2>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center py-5" style="color:var(--medium-brown);">
            <i class="fas fa-shopping-bag fa-3x mb-3" style="opacity:0.4;"></i>
            <p>No orders placed yet.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order):
                        $status = $order['status'] ?? 'pending';
                        $badgeClass = match($status) {
                            'delivered','completed' => 'completed',
                            'pending'               => 'pending',
                            'cancelled'             => 'inactive',
                            default                 => 'pending'
                        };
                        $badgeBg = match($status) {
                            'delivered','completed' => '#2E7D32',
                            'pending'               => '#F57F17',
                            'cancelled'             => '#C62828',
                            'processing'            => '#1565C0',
                            'out_for_delivery'      => '#7B1FA2',
                            default                 => '#F57F17'
                        };
                    ?>
                        <tr>
                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                            <td>
                                <div style="font-weight:600;"><?php echo SecurityHelper::escape($order['customer_name'] ?? 'Guest'); ?></div>
                                <div style="font-size:0.8rem;color:var(--medium-brown);">User #<?php echo $order['user_id']; ?></div>
                            </td>
                            <td><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></td>
                            <td>
                                <span style="text-transform:capitalize;"><?php echo SecurityHelper::escape($order['payment_method'] ?? 'N/A'); ?></span>
                            </td>
                            <td><strong>Rs. <?php echo number_format($order['total_amount'], 2); ?></strong></td>
                            <td>
                                <span class="status-badge" style="background:<?php echo $badgeBg; ?>20;color:<?php echo $badgeBg; ?>;">
                                    <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                                </span>
                            </td>
                            <td>
                                <form method="post" action="" class="d-flex gap-2 align-items-center">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" style="width:160px;border-radius:8px;border-color:var(--cream);">
                                        <option value="pending"          <?php echo $status==='pending'          ?'selected':''; ?>>Pending</option>
                                        <option value="processing"       <?php echo $status==='processing'       ?'selected':''; ?>>Processing</option>
                                        <option value="out_for_delivery" <?php echo $status==='out_for_delivery' ?'selected':''; ?>>Out for Delivery</option>
                                        <option value="delivered"        <?php echo $status==='delivered'        ?'selected':''; ?>>Delivered</option>
                                        <option value="cancelled"        <?php echo $status==='cancelled'        ?'selected':''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_status"
                                            class="btn-action edit" style="padding:7px 14px;font-size:0.82rem;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>
