<?php
/**
 * Remove from Cart Handler
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cartId = intval($_POST['cart_id']);
    
    $cartModel = new Cart();
    $cartModel->remove($cartId);
}

header("Location: cart.php");
exit();
