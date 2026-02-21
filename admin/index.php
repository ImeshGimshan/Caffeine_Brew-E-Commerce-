<?php
/**
 * Admin Dashboard
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/models/Reservation.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$productModel = new Product();
$cartModel = new Cart();
$reservationModel = new Reservation();

// Get statistics
$totalProducts = count($productModel->getAll());
$cartItems = count($cartModel->getAll());
$totalReservations = count($reservationModel->getAll());

$pageTitle = 'Admin Dashboard';
$currentPage = 'dashboard';
?>

<?php include dirname(__DIR__) . '/includes/header.php'; ?>
<?php include dirname(__DIR__) . '/includes/admin-navbar.php'; ?>

<div class="container-fluid mt-4">
    <h1 class="mb-4"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Products</h5>
                            <h2><?php echo $totalProducts; ?></h2>
                        </div>
                        <i class="fas fa-box fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo BASE_URL; ?>/admin/products/manage.php" class="text-white">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Cart Items</h5>
                            <h2><?php echo $cartItems; ?></h2>
                        </div>
                        <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo BASE_URL; ?>/user/cart/cart.php" class="text-white">
                        View Cart <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Reservations</h5>
                            <h2><?php echo $totalReservations; ?></h2>
                        </div>
                        <i class="fas fa-calendar fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?php echo BASE_URL; ?>/admin/reservations/manage.php" class="text-white">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Site Views</h5>
                            <h2>N/A</h2>
                        </div>
                        <i class="fas fa-eye fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <span class="text-white">Analytics not configured</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?php echo BASE_URL; ?>/admin/products/add.php" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-plus"></i><br>Add Product
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo BASE_URL; ?>/admin/products/manage.php" class="btn btn-success btn-block btn-lg">
                                <i class="fas fa-edit"></i><br>Manage Products
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo BASE_URL; ?>/admin/reservations/manage.php" class="btn btn-warning btn-block btn-lg">
                                <i class="fas fa-calendar-check"></i><br>View Reservations
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo BASE_URL; ?>/public/index.php" target="_blank" class="btn btn-info btn-block btn-lg">
                                <i class="fas fa-external-link-alt"></i><br>View Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.opacity-50 {
    opacity: 0.5;
}
.card-footer a {
    text-decoration: none;
}
.card-footer a:hover {
    text-decoration: underline;
}
</style>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
