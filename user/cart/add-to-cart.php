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

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Get product details
    $productModel = new Product();
    $product = $productModel->getById($productId);
    
    if ($product) {
        $cartModel = new Cart();
        $userId = SessionHelper::getUserId();
        
        if ($cartModel->add($productId, $product['name'], $product['price'], $quantity, $userId)) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'cartCount' => $cartModel->getCount($userId)]);
                exit();
            }
            $_SESSION['success_message'] = 'Product added to cart!';
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
                exit();
            }
            $_SESSION['error_message'] = 'Failed to add product to cart.';
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
            exit();
        }
        $_SESSION['error_message'] = 'Product not found.';
    }
}

// Fallback redirect for non-AJAX
header("Location: " . BASE_URL . "/user/products/products.php");
exit();
