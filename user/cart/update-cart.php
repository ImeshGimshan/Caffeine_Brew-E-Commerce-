<?php
/**
 * Update Cart Handler
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cartId = intval($_POST['cart_id']);
    $quantity = max(1, intval($_POST['quantity'])); // Minimum quantity is 1
    
    $cartModel = new Cart();
    $cartItem = $cartModel->getById($cartId);
    
    if ($cartItem) {
        // Update using product ID from cart item
        $cartModel->updateQuantity($cartItem['pid'], $quantity);
    }
}

header("Location: cart.php");
exit();
