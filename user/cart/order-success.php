<?php
/**
 * Order Success Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();

$pageTitle = 'Order Successful';
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<div class="container mt-5 mb-5 text-center">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body p-5">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            <h1 class="mt-4">Order Successful!</h1>
            <p class="lead">Thank you for your order.</p>
            <p>Your order has been placed successfully and is being processed. You will receive a confirmation email shortly.</p>
            
            <div class="mt-4">
                <a href="<?php echo BASE_URL; ?>/public/index.php" class="btn btn-primary btn-lg mr-2">
                    <i class="fas fa-home"></i> Go to Home
                </a>
                <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn btn-success btn-lg">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
