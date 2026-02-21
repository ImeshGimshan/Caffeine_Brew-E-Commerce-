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
$customCSS = ['admin.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-plus me-2"></i> Add New Product</h1>
    <div class="admin-header-actions">
        <a href="manage.php"
           class="btn btn-sm" style="background:var(--light-cream);color:var(--dark-brown);border-radius:8px;padding:8px 18px;border:1px solid var(--cream);">
            <i class="fas fa-arrow-left me-1"></i> Back to Products
        </a>
    </div>
</div>

<div class="content-section admin-form" style="max-width:800px;">
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:var(--dark-brown);">Product Name *</label>
            <input type="text" name="name" class="form-control" required
                   placeholder="e.g. Caramel Latte">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:var(--dark-brown);">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Short description of the product..."></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color:var(--dark-brown);">Price (Rs.) *</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0" required
                       placeholder="0.00">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color:var(--dark-brown);">Category *</label>
                <select name="category" class="form-select" required>
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

        <div class="mb-4">
            <label class="form-label fw-semibold" style="color:var(--dark-brown);">Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" id="imgInput">
            <div class="form-text">Max 5 MB · JPG, PNG, GIF</div>
            <div id="imgPreview" class="file-preview mt-2"></div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" name="add_product"
                    class="btn btn-lg px-4" style="background:var(--primary-brown);color:white;border-radius:10px;">
                <i class="fas fa-save me-2"></i> Add Product
            </button>
            <a href="manage.php" class="btn btn-lg btn-outline-secondary px-4" style="border-radius:10px;">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('imgInput').addEventListener('change', function () {
    const preview = document.getElementById('imgPreview');
    preview.innerHTML = '';
    if (this.files && this.files[0]) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(this.files[0]);
        preview.appendChild(img);
    }
});
</script>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>
