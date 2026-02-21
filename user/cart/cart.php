<?php
/**
 * Shopping Cart Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();

$cartModel = new Cart();
$cartItems = $cartModel->getAll();
$grandTotal = $cartModel->getTotal();

$pageTitle = 'Shopping Cart';
$currentPage = 'cart';
$customCSS = ['cart.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<div class="container mt-5">
    <section class="scart">
        <h1 class="heading">Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <h4>Your cart is empty</h4>
                <p>Add some products to get started!</p>
                <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            $totalPrice = $item['price'] * $item['quantity'];
                            ?>
                            <tr id="product-<?php echo $item['cid']; ?>">
                                <td><?php echo $item['pid']; ?></td>
                                <td><?php echo SecurityHelper::escape($item['name']); ?></td>
                                <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <form action="update-cart.php" method="post" class="d-inline">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cid']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" max="99" class="form-control d-inline" style="width: 80px;">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>Rs. <?php echo number_format($totalPrice, 2); ?></td>
                                <td>
                                    <form action="remove-from-cart.php" method="post" class="d-inline" 
                                          onsubmit="return confirm('Remove this item from cart?');">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cid']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                            <td colspan="2"><strong>Rs. <?php echo number_format($grandTotal, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="cart-actions text-right mt-4">
                <form action="clear-cart.php" method="post" class="d-inline" 
                      onsubmit="return confirm('Clear entire cart?');">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-trash-alt"></i> Clear Cart
                    </button>
                </form>
                <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="<?php echo BASE_URL; ?>/user/cart/checkout.php" class="btn btn-success">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
