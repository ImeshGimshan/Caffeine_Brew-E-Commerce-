<?php
/**
 * Edit Product - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$productModel = new Product();
$error = '';
$success = '';

// Get product ID
if (!isset($_GET['id'])) {
    header("Location: manage.php");
    exit();
}

$productId = intval($_GET['id']);
$product = $productModel->getById($productId);

if (!$product) {
    $_SESSION['error_message'] = 'Product not found.';
    header("Location: manage.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $name = SecurityHelper::sanitize($_POST['name']);
    $description = SecurityHelper::sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $category = SecurityHelper::sanitize($_POST['category']);
    
    $updateData = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category' => $category
    ];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = UPLOADS_PATH . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $imageExtension;
        $uploadPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Delete old image
            if ($product['image'] && file_exists($uploadDir . $product['image'])) {
                unlink($uploadDir . $product['image']);
            }
            $updateData['image'] = $imageName;
        }
    }
    
    if ($productModel->update($productId, $updateData)) {
        $_SESSION['success_message'] = 'Product updated successfully!';
        header("Location: manage.php");
        exit();
    } else {
        $error = 'Failed to update product.';
    }
}

$pageTitle = 'Edit Product';
$currentPage = 'products';
$customCSS = ['editproduct.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<div class="container mt-4 mb-5">
    <h1 class="mb-4"><i class="fas fa-edit"></i> Edit Product</h1>
    
    <div class="card">
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?php echo SecurityHelper::escape($product['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo SecurityHelper::escape($product['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Price (Rs.) *</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" 
                               value="<?php echo $product['price']; ?>" required>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Category *</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Coffees" <?php echo $product['category'] === 'Coffees' ? 'selected' : ''; ?>>Coffee</option>
                            <option value="Icecreams" <?php echo $product['category'] === 'Icecreams' ? 'selected' : ''; ?>>Ice Cream</option>
                            <option value="Cakes" <?php echo $product['category'] === 'Cakes' ? 'selected' : ''; ?>>Cakes</option>
                            <option value="Buns" <?php echo $product['category'] === 'Buns' ? 'selected' : ''; ?>>Buns</option>
                            <option value="Pizza" <?php echo $product['category'] === 'Pizza' ? 'selected' : ''; ?>>Pizza</option>
                            <option value="Bubble Tea" <?php echo $product['category'] === 'Bubble Tea' ? 'selected' : ''; ?>>Bubble Tea</option>
                            <option value="Juice" <?php echo $product['category'] === 'Juice' ? 'selected' : ''; ?>>Juice</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Product Image</label>
                    <?php if ($product['image']): ?>
                        <div class="mb-2">
                            <img src="<?php echo BASE_URL; ?>/assets/uploads/<?php echo $product['image']; ?>" 
                                 alt="Current Image" style="max-width: 200px;">
                            <p class="text-muted">Current image</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Leave empty to keep current image. Maximum file size: 5MB.</small>
                </div>
                
                <div class="mt-4">
                    <button type="submit" name="update_product" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                    <a href="manage.php" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
