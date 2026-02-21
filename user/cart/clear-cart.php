<?php
/**
 * Clear Cart Handler
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();

$cartModel = new Cart();
$userId = SessionHelper::getUserId();
$cartModel->clear($userId);

header("Location: cart.php");
exit();
