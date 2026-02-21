<?php
/**
 * Add to Cart Handler
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Get product details
    $productModel = new Product();
    $product = $productModel->getById($productId);
    
    if ($product) {
        $cartModel = new Cart();
        $userId = SessionHelper::getUserId();
        
        // Add to cart
        if ($cartModel->add($productId, $product['name'], $product['price'], $quantity, $userId)) {
            $_SESSION['success_message'] = 'Product added to cart!';
        } else {
            $_SESSION['error_message'] = 'Failed to add product to cart.';
        }
    } else {
        $_SESSION['error_message'] = 'Product not found.';
    }
    
    // Redirect back to products page
    header("Location: " . BASE_URL . "/user/products/products.php");
    exit();
} else {
    header("Location: " . BASE_URL . "/user/products/products.php");
    exit();
}
