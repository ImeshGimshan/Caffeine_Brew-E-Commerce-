<?php
/**
 * Order Success Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();

$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$pageTitle = 'Order Successful';
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<div class="container my-5">
    <div class="card mx-auto border-0 shadow-sm text-center" style="max-width:600px;border-radius:20px;overflow:hidden;">

        <div class="py-4 px-3" style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));">
            <i class="fas fa-check-circle" style="font-size:4rem;color:#fff;"></i>
            <h2 class="mt-3 mb-1" style="color:#fff;font-family:var(--font-heading);">Order Placed!</h2>
            <?php if ($orderId): ?>
                <p style="color:#FFE4C4;margin:0;">Order #<?php echo str_pad($orderId, 5, '0', STR_PAD_LEFT); ?></p>
            <?php endif; ?>
        </div>

        <div class="card-body p-4">
            <p class="lead mb-1" style="color:var(--dark-brown);">Thank you for your order!</p>
            <p class="text-muted mb-4">Your order is being processed. You can track it in My Orders.</p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?php if ($orderId): ?>
                    <a href="<?php echo BASE_URL; ?>/user/orders/order-detail.php?id=<?php echo $orderId; ?>"
                       class="landing-brown-btn">
                        <i class="fas fa-receipt me-2"></i> View Order
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/user/orders/orders.php"
                   class="about-cta-btn">
                    <i class="fas fa-shopping-bag me-2"></i> My Orders
                </a>
                <a href="<?php echo BASE_URL; ?>/user/products/products.php"
                   class="about-cta-btn">
                    <i class="fas fa-coffee me-2"></i> Continue Shopping
                </a>
            </div>
        </div>

    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
