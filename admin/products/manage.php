<?php
/**
 * Manage Products - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$productModel = new Product();
$products = $productModel->getAll();

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($productModel->delete($id)) {
        $_SESSION['success_message'] = 'Product deleted successfully!';
    } else {
        $_SESSION['error_message'] = 'Failed to delete product.';
    }
    header("Location: manage.php");
    exit();
}

$pageTitle = 'Manage Products';
$currentPage = 'products';
$customCSS = ['admin.css'];

$successMessage = SessionHelper::get('success_message');
$errorMessage = SessionHelper::get('error_message');
if ($successMessage) SessionHelper::remove('success_message');
if ($errorMessage) SessionHelper::remove('error_message');
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-box"></i> Manage Products</h1>
        <a href="add.php" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>
    
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
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No products found. Add your first product!
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td>
                                        <?php if ($product['image']): ?>
                                            <img src="<?php echo BASE_URL; ?>/assets/uploads/<?php echo $product['image']; ?>" 
                                                 alt="<?php echo SecurityHelper::escape($product['name']); ?>"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo SecurityHelper::escape($product['name']); ?></td>
                                    <td><?php echo SecurityHelper::escape($product['category'] ?? 'N/A'); ?></td>
                                    <td>Rs. <?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo SecurityHelper::escape(substr($product['description'] ?? '', 0, 50)); ?>...</td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="manage.php?delete=<?php echo $product['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Delete this product?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
