<?php
/**
 * Checkout Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

$cartModel = new Cart();
$cartItems = $cartModel->getAll();
$grandTotal = $cartModel->getTotal();

// Redirect if cart is empty
if (empty($cartItems)) {
    header("Location: cart.php");
    exit();
}

$pageTitle = 'Checkout';
$customCSS = ['checkout.css'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = SecurityHelper::sanitize($_POST['name']);
    $email = SecurityHelper::sanitize($_POST['email']);
    $phone = SecurityHelper::sanitize($_POST['phone']);
    $address = SecurityHelper::sanitize($_POST['address']);
    $paymentMethod = SecurityHelper::sanitize($_POST['payment_method']);
    
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($paymentMethod)) {
        $error = 'Please fill in all fields';
    } else {
        // Here you would typically:
        // 1. Create order in database
        // 2. Process payment
        // 3. Clear cart
        // 4. Send confirmation email
        
        // For now, just clear cart and show success
        $cartModel->clear(SessionHelper::getUserId());
        
        header("Location: " . BASE_URL . "/user/cart/order-success.php");
        exit();
    }
}
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <h1 class="mb-4">Checkout</h1>
    
    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-shopping-cart"></i> Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo SecurityHelper::escape($item['name']); ?> x<?php echo $item['quantity']; ?></span>
                            <span>Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>Rs. <?php echo number_format($grandTotal, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-user"></i> Billing Information</h5>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone *</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Delivery Address *</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Payment Method *</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash on Delivery</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Special Instructions (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" name="place_order" class="btn btn-success btn-lg btn-block">
                                <i class="fas fa-check"></i> Place Order
                            </button>
                            <a href="cart.php" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Back to Cart
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
