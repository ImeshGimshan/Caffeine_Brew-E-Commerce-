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

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-box me-2"></i> Manage Products</h1>
    <div class="admin-header-actions">
        <a href="add.php"
           class="btn btn-sm" style="background:var(--primary-brown);color:white;border-radius:8px;padding:8px 18px;">
            <i class="fas fa-plus me-1"></i> Add New Product
        </a>
    </div>
</div>

<?php if ($successMessage): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $successMessage; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $errorMessage; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-list me-2" style="color:var(--gold-accent);"></i> All Products
            <span class="badge ms-2" style="background:var(--primary-brown);font-size:0.8rem;"><?php echo count($products); ?></span>
        </h2>
    </div>

    <?php if (empty($products)): ?>
        <div class="text-center py-5" style="color:var(--medium-brown);">
            <i class="fas fa-box-open fa-3x mb-3" style="opacity:0.4;"></i>
            <p class="mb-3">No products found.</p>
            <a href="add.php" class="btn-action edit" style="text-decoration:none;">Add Your First Product</a>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
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
                                         class="product-image-thumb">
                                <?php else: ?>
                                    <div style="width:60px;height:60px;background:var(--light-cream);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--medium-brown);">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo SecurityHelper::escape($product['name']); ?></strong></td>
                            <td>
                                <span class="status-badge pending"><?php echo SecurityHelper::escape($product['category'] ?? 'N/A'); ?></span>
                            </td>
                            <td><strong>Rs. <?php echo number_format($product['price'], 2); ?></strong></td>
                            <td style="max-width:200px;color:var(--medium-brown);">
                                <?php echo SecurityHelper::escape(substr($product['description'] ?? '', 0, 60)); ?>…
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn-action edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="manage.php?delete=<?php echo $product['id']; ?>"
                                       class="btn-action delete"
                                       onclick="return confirm('Delete \'<?php echo SecurityHelper::escape($product['name']); ?>\'?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>
