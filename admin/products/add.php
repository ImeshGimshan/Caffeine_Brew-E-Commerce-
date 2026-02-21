<?php
/**
 * Add Product - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = SecurityHelper::sanitize($_POST['name']);
    $description = SecurityHelper::sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $category = SecurityHelper::sanitize($_POST['category']);
    
    // Handle image upload
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = UPLOADS_PATH . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $imageExtension;
        $uploadPath = $uploadDir . $imageName;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $error = 'Failed to upload image.';
        }
    }
    
    if (!$error) {
        $productData = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category,
            'image' => $imageName
        ];
        
        $productModel = new Product();
        if ($productModel->create($productData)) {
            $_SESSION['success_message'] = 'Product added successfully!';
            header("Location: manage.php");
            exit();
        } else {
            $error = 'Failed to add product.';
        }
    }
}

$pageTitle = 'Add Product';
$currentPage = 'products';
$customCSS = ['addproduct.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<div class="container mt-4 mb-5">
    <h1 class="mb-4"><i class="fas fa-plus"></i> Add New Product</h1>
    
    <div class="card">
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Price (Rs.) *</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Category *</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Coffees">Coffee</option>
                            <option value="Icecreams">Ice Cream</option>
                            <option value="Cakes">Cakes</option>
                            <option value="Buns">Buns</option>
                            <option value="Pizza">Pizza</option>
                            <option value="Bubble Tea">Bubble Tea</option>
                            <option value="Juice">Juice</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="image" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Maximum file size: 5MB. Accepted formats: JPG, PNG, GIF</small>
                </div>
                
                <div class="mt-4">
                    <button type="submit" name="add_product" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Add Product
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
