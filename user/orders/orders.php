<?php
/**
 * My Orders Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Order.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

// Redirect to login if not logged in
if (!SessionHelper::isLoggedIn()) {
    SecurityHelper::redirect(BASE_URL . '/user/auth/login.php');
}

$userId    = SessionHelper::getUserId();
$orderModel = new Order();
$orders    = $orderModel->getByUser($userId);

$pageTitle   = 'My Orders';
$currentPage = 'orders';
$customCSS   = ['pages.css', 'cart.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Hero Banner -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">My Orders</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">Track and review your order history</p>
    </div>
</section>

<div class="container my-5">

    <?php if (empty($orders)): ?>
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x mb-4" style="color:var(--primary-brown);opacity:0.5;"></i>
            <h3 style="color:var(--dark-brown);">No orders yet</h3>
            <p class="text-muted mb-4">You haven't placed any orders. Start shopping!</p>
            <a href="<?php echo BASE_URL; ?>/user/products/products.php"
               class="landing-brown-btn">
                <i class="fas fa-coffee me-2"></i> Browse Menu
            </a>
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($orders as $order): ?>
                <?php
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
                <div class="col-12" data-aos="fade-up">
                    <div class="card shadow-sm border-0" style="border-radius:16px;overflow:hidden;">

                        <!-- Card Header -->
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2 py-3"
                             style="background:var(--cream);border-bottom:2px solid #f0e8e0;">
                            <div>
                                <span class="fw-bold" style="color:var(--dark-brown);font-size:1.05rem;">
                                    Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?>
                                </span>
                                <span class="ms-3 text-muted" style="font-size:0.9rem;">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?>
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="px-3 py-1 rounded-pill fw-semibold"
                                      style="background:<?php echo $s['bg']; ?>;color:<?php echo $s['text']; ?>;font-size:0.85rem;">
                                    <i class="fas <?php echo $s['icon']; ?> me-1"></i>
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                                <span class="fw-bold" style="color:var(--primary-brown);font-size:1.1rem;">
                                    Rs. <?php echo number_format($order['total_amount'], 2); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body py-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p class="mb-1" style="color:var(--dark-brown);font-size:0.9rem;">
                                        <i class="fas fa-map-marker-alt me-2" style="color:var(--primary-brown);"></i>
                                        <strong>Delivery:</strong>
                                        <?php echo SecurityHelper::escape($order['shipping_address']); ?>
                                    </p>
                                    <p class="mb-0" style="color:var(--dark-brown);font-size:0.9rem;">
                                        <i class="fas fa-credit-card me-2" style="color:var(--primary-brown);"></i>
                                        <strong>Payment:</strong>
                                        <?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?>
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="<?php echo BASE_URL; ?>/user/orders/order-detail.php?id=<?php echo $order['id']; ?>"
                                       class="landing-brown-btn" style="padding:10px 22px;font-size:0.9rem;">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
