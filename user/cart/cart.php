<?php
/**
 * Shopping Cart Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

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
            <div class="text-center py-5" style="background:#FDF6F0;border-radius:16px;border:1px solid #f0e8e0;">
                <i class="fas fa-shopping-cart fa-3x mb-3" style="color:var(--primary-brown);"></i>
                <h4>Your cart is empty</h4>
                <p>Add some products to get started!</p>
                <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered" style="table-layout:fixed;width:100%;">
                    <colgroup>
                        <col style="width:10%;">
                        <col style="width:28%;">
                        <col style="width:14%;">
                        <col style="width:16%;">
                        <col style="width:16%;">
                        <col style="width:16%;">
                    </colgroup>
                    <thead class="table-dark">
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
                            <tr id="product-<?php echo $item['cid']; ?>" data-price="<?php echo $item['price']; ?>">
                                <td><?php echo $item['pid']; ?></td>
                                <td><?php echo SecurityHelper::escape($item['name']); ?></td>
                                <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" name="quantity"
                                           value="<?php echo $item['quantity']; ?>"
                                           min="1" max="99"
                                           class="form-control d-inline qty-live"
                                           style="width:75px;min-width:0;"
                                           data-cart-id="<?php echo $item['cid']; ?>">
                                </td>
                                <td class="row-total">Rs. <?php echo number_format($totalPrice, 2); ?></td>
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
                            <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                            <td colspan="2"><strong id="grand-total-cell">Rs. <?php echo number_format($grandTotal, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="cart-actions text-end mt-4">
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

<script>
document.querySelectorAll('.qty-live').forEach(function(input) {
    let debounceTimer;

    input.addEventListener('input', function() {
        const qty = Math.max(1, parseInt(this.value) || 1);
        this.value = qty;

        const row = this.closest('tr');
        const price = parseFloat(row.dataset.price);
        const rowTotalCell = row.querySelector('.row-total');
        rowTotalCell.textContent = 'Rs. ' + (price * qty).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Recalculate grand total
        let grand = 0;
        document.querySelectorAll('tbody tr').forEach(function(r) {
            const p = parseFloat(r.dataset.price);
            const q = parseInt(r.querySelector('.qty-live').value) || 1;
            grand += p * q;
        });
        document.getElementById('grand-total-cell').textContent =
            'Rs. ' + grand.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Debounce AJAX save
        const indicator = row.querySelector('.save-indicator');
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const cartId = this.dataset.cartId;
            const formData = new FormData();
            formData.append('cart_id', cartId);
            formData.append('quantity', qty);

            fetch('<?php echo BASE_URL; ?>/user/cart/update-cart.php', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });
        }, 600);
    }.bind(input));
});
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
