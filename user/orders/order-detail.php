<?php
/**
 * Order Detail Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Order.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

if (!SessionHelper::isLoggedIn()) {
    SecurityHelper::redirect(BASE_URL . '/user/auth/login.php');
}

$orderId   = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userId    = SessionHelper::getUserId();
$orderModel = new Order();
$order     = $orderModel->getById($orderId, $userId);

if (!$order) {
    SecurityHelper::redirect(BASE_URL . '/user/orders/orders.php');
}

$pageTitle   = 'Order #' . str_pad($order['id'], 5, '0', STR_PAD_LEFT);
$currentPage = 'orders';
$customCSS   = ['pages.css', 'cart.css'];

$statusColors = [
    'pending'   => ['bg' => '#FFF3CD', 'text' => '#856404', 'icon' => 'fa-clock'],
    'confirmed' => ['bg' => '#D1ECF1', 'text' => '#0C5460', 'icon' => 'fa-check-circle'],
    'preparing' => ['bg' => '#D4EDDA', 'text' => '#155724', 'icon' => 'fa-blender'],
    'ready'     => ['bg' => '#CCE5FF', 'text' => '#004085', 'icon' => 'fa-box'],
    'delivered' => ['bg' => '#D4EDDA', 'text' => '#155724', 'icon' => 'fa-check-double'],
    'cancelled' => ['bg' => '#F8D7DA', 'text' => '#721C24', 'icon' => 'fa-times-circle'],
];
$s = $statusColors[$order['status']] ?? $statusColors['pending'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Hero Banner -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">Order Details</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></p>
    </div>
</section>

<div class="container my-5">

    <a href="<?php echo BASE_URL; ?>/user/orders/orders.php"
       class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left me-2"></i> Back to My Orders
    </a>

    <div class="row g-4">

        <!-- Order Summary Card -->
        <div class="col-md-4" data-aos="fade-right">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;">
                <div class="card-header py-3 fw-bold"
                     style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));color:white;font-size:1rem;">
                    <i class="fas fa-receipt me-2"></i> Order Summary
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="font-size:0.95rem;color:var(--dark-brown);">
                        <li class="py-2 border-bottom">
                            <span class="text-muted">Order ID</span><br>
                            <strong>#<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></strong>
                        </li>
                        <li class="py-2 border-bottom">
                            <span class="text-muted">Date Placed</span><br>
                            <strong><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></strong>
                        </li>
                        <li class="py-2 border-bottom">
                            <span class="text-muted">Status</span><br>
                            <span class="px-2 py-1 rounded-pill fw-semibold"
                                  style="background:<?php echo $s['bg']; ?>;color:<?php echo $s['text']; ?>;font-size:0.85rem;">
                                <i class="fas <?php echo $s['icon']; ?> me-1"></i>
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </li>
                        <li class="py-2 border-bottom">
                            <span class="text-muted">Payment Method</span><br>
                            <strong><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></strong>
                        </li>
                        <li class="py-2 border-bottom">
                            <span class="text-muted">Delivery Address</span><br>
                            <strong><?php echo SecurityHelper::escape($order['shipping_address']); ?></strong>
                        </li>
                        <li class="py-2">
                            <span class="text-muted">Grand Total</span><br>
                            <strong style="font-size:1.3rem;color:var(--primary-brown);">
                                Rs. <?php echo number_format($order['total_amount'], 2); ?>
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Order Items Card -->
        <div class="col-md-8" data-aos="fade-left">
            <div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
                <div class="card-header py-3 fw-bold"
                     style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));color:white;font-size:1rem;">
                    <i class="fas fa-coffee me-2"></i> Items Ordered
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0" style="font-size:0.95rem;">
                        <thead style="background:var(--cream);">
                            <tr>
                                <th class="py-3 ps-4">Item</th>
                                <th class="py-3 text-center">Qty</th>
                                <th class="py-3 text-center">Unit Price</th>
                                <th class="py-3 text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td class="py-3 ps-4 fw-semibold" style="color:var(--dark-brown);">
                                        <?php echo SecurityHelper::escape($item['product_name']); ?>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-pill"
                                              style="background:var(--primary-brown);font-size:0.85rem;padding:6px 12px;">
                                            <?php echo $item['quantity']; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 text-center" style="color:var(--dark-brown);">
                                        Rs. <?php echo number_format($item['price'], 2); ?>
                                    </td>
                                    <td class="py-3 text-end pe-4 fw-bold" style="color:var(--primary-brown);">
                                        Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot style="background:var(--cream);">
                            <tr>
                                <td colspan="3" class="text-end fw-bold py-3" style="color:var(--dark-brown);">
                                    Grand Total
                                </td>
                                <td class="text-end pe-4 fw-bold py-3"
                                    style="color:var(--primary-brown);font-size:1.1rem;">
                                    Rs. <?php echo number_format($order['total_amount'], 2); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
