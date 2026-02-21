<?php
/**
 * Products Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

$productModel = new Product();

// Get category filter
$category = isset($_GET['category']) ? SecurityHelper::sanitize($_GET['category']) : '';

// Get products
if ($category) {
    $products = $productModel->getByCategory($category);
} else {
    $products = $productModel->getAll();
}

// Get all categories
$categories = $productModel->getCategories();

$pageTitle = 'Products';
$currentPage = 'products';
$customCSS = ['products.css'];

// Check for flash messages
$successMessage = SessionHelper::get('success_message');
$errorMessage = SessionHelper::get('error_message');
if ($successMessage) {
    SessionHelper::remove('success_message');
}
if ($errorMessage) {
    SessionHelper::remove('error_message');
}
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Banner Section -->
<section class="banner-section text-center">
    <div class="banner-content">
        <h1>OUR MENU</h1>
        <p>Choose from our delicious selection</p>
    </div>
</section>

<!-- Products Section -->
<div class="container-fluid mt-4">
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $successMessage; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $errorMessage; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <h4 class="list-group-item active">Categories</h4>
                <a href="products.php" class="list-group-item <?php echo !$category ? 'active' : ''; ?>">
                    All Products
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="?category=<?php echo urlencode($cat['category']); ?>" 
                       class="list-group-item <?php echo $category === $cat['category'] ? 'active' : ''; ?>">
                        <?php echo SecurityHelper::escape($cat['category']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-md-9">
            <h2 class="mb-4">
                <?php echo $category ? SecurityHelper::escape($category) : 'All Products'; ?>
            </h2>
            
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No products found in this category.
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if ($product['image']): ?>
                                    <img src="<?php echo BASE_URL; ?>/assets/uploads/<?php echo $product['image']; ?>" 
                                         class="card-img-top" alt="<?php echo SecurityHelper::escape($product['name']); ?>"
                                         style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-white"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo SecurityHelper::escape($product['name']); ?></h5>
                                    <p class="card-text text-muted">
                                        <?php echo SecurityHelper::escape($product['description'] ?? ''); ?>
                                    </p>
                                    <p class="card-text">
                                        <strong class="text-primary">Rs. <?php echo number_format($product['price'], 2); ?></strong>
                                    </p>
                                </div>
                                
                                <div class="card-footer bg-white">
                                    <form action="<?php echo BASE_URL; ?>/user/cart/add-to-cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="1" min="1" max="99" 
                                                   class="form-control" style="max-width: 80px;">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
