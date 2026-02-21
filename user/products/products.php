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
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">Our Menu</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">Choose from our delicious selection</p>
    </div>
</section>

<!-- Products Section -->
<div class="container-fluid px-4 px-lg-5 mt-2 mb-5">

    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Sidebar Filter -->
        <div class="col-lg-3 col-md-4 filter-col" data-aos="fade-right">
            <div class="filter-section">
                <h5><i class="fas fa-filter me-2"></i>Categories</h5>

                <a href="products.php"
                   class="category-item <?php echo !$category ? 'active' : ''; ?>">
                    <i class="fas fa-th-large"></i> All Products
                </a>

                <?php foreach ($categories as $cat): ?>
                    <a href="?category=<?php echo urlencode($cat['category']); ?>"
                       class="category-item <?php echo $category === $cat['category'] ? 'active' : ''; ?>">
                        <i class="fas fa-tag"></i>
                        <?php echo SecurityHelper::escape($cat['category']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9 col-md-8">

            <!-- Search & Sort Bar -->
            <div class="search-sort-bar mb-4" data-aos="fade-down">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="productSearch" placeholder="Search products…">
                </div>
                <div class="sort-box">
                    <label for="sortSelect"><i class="fas fa-sort me-1"></i> Sort by:</label>
                    <select id="sortSelect">
                        <option value="default">Default</option>
                        <option value="name-asc">Name A–Z</option>
                        <option value="name-desc">Name Z–A</option>
                        <option value="price-asc">Price: Low → High</option>
                        <option value="price-desc">Price: High → Low</option>
                    </select>
                </div>
            </div>

            <!-- Heading -->
            <h2 class="mb-4" style="font-family: var(--font-heading); color: var(--dark-brown);" data-aos="fade-up">
                <?php echo $category ? SecurityHelper::escape($category) : 'All Products'; ?>
                <span style="font-size: 1rem; color: var(--medium-brown); font-family: var(--font-body); font-weight: 400;">
                    (<?php echo count($products); ?> items)
                </span>
            </h2>

            <?php if (empty($products)): ?>
                <div class="empty-products" data-aos="fade-up">
                    <i class="fas fa-coffee"></i>
                    <h3>No Products Found</h3>
                    <p>Try a different category or check back later.</p>
                    <a href="products.php" class="btn about-cta-btn">View All Products</a>
                </div>
            <?php else: ?>
                <div class="products-container" id="productsGrid">
                    <?php foreach ($products as $i => $product): ?>
                        <div class="modern-product-card product-item"
                             data-name="<?php echo strtolower(SecurityHelper::escape($product['name'])); ?>"
                             data-price="<?php echo $product['price']; ?>"
                             data-aos="fade-up" data-aos-delay="<?php echo min(($i % 3) * 100, 300); ?>">

                            <!-- Image -->
                            <div class="product-image-wrapper">
                                <?php if ($product['image']): ?>
                                    <img src="<?php echo ASSETS_URL; ?>/uploads/<?php echo rawurlencode($product['image']); ?>"
                                         alt="<?php echo SecurityHelper::escape($product['name']); ?>"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="img-fallback">
                                        <i class="fas fa-coffee fa-4x" style="color: var(--light-brown);"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="img-fallback" style="display:flex">
                                        <i class="fas fa-coffee fa-4x" style="color: var(--light-brown);"></i>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($product['category'])): ?>
                                    <span class="product-category-badge">
                                        <?php echo SecurityHelper::escape($product['category']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Body -->
                            <div class="product-body">
                                <h3 class="product-title"><?php echo SecurityHelper::escape($product['name']); ?></h3>
                                <p class="product-description">
                                    <?php echo SecurityHelper::escape($product['description'] ?? ''); ?>
                                </p>

                                <div class="product-footer">
                                    <div class="product-price">
                                        <small>Rs.</small> <?php echo number_format($product['price'], 2); ?>
                                    </div>

                                    <form action="<?php echo BASE_URL; ?>/user/cart/add-to-cart.php" method="post"
                                          class="cart-row">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="number" name="quantity" value="1" min="1" max="99"
                                               class="qty-input">
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
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

<!-- Inline search + sort JS -->
<script>
(function () {
    const searchInput = document.getElementById('productSearch');
    const sortSelect  = document.getElementById('sortSelect');
    const grid        = document.getElementById('productsGrid');

    function getCards() {
        return grid ? Array.from(grid.querySelectorAll('.product-item')) : [];
    }

    function applyFilters() {
        const q     = searchInput ? searchInput.value.toLowerCase() : '';
        const sort  = sortSelect  ? sortSelect.value : 'default';
        let cards = getCards();

        // Filter
        cards.forEach(c => {
            const name = c.dataset.name || '';
            c.style.display = name.includes(q) ? '' : 'none';
        });

        // Sort
        const visible = cards.filter(c => c.style.display !== 'none');
        visible.sort((a, b) => {
            if (sort === 'name-asc')   return a.dataset.name.localeCompare(b.dataset.name);
            if (sort === 'name-desc')  return b.dataset.name.localeCompare(a.dataset.name);
            if (sort === 'price-asc')  return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if (sort === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            return 0;
        });
        visible.forEach(c => grid.appendChild(c));
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (sortSelect)  sortSelect.addEventListener('change', applyFilters);
})();

// AJAX Add to Cart
document.querySelectorAll('.cart-row').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = form.querySelector('.add-to-cart-btn');
        const originalHTML = btn.innerHTML;
        const formData = new FormData(form);

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

        fetch('<?php echo BASE_URL; ?>/user/cart/add-to-cart.php', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> Added!';
                btn.style.background = 'var(--primary-brown)';

                // Update cart badge in navbar
                const badge = document.querySelector('.cart-badge');
                if (badge) {
                    badge.textContent = data.cartCount;
                } else {
                    const cartLink = document.querySelector('.cart-link');
                    if (cartLink) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'cart-badge';
                        newBadge.textContent = data.cartCount;
                        cartLink.appendChild(newBadge);
                    }
                }
            } else {
                btn.innerHTML = '<i class="fas fa-times"></i> Failed';
                btn.style.background = '#c0392b';
            }
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.style.background = '';
                btn.disabled = false;
            }, 1500);
        })
        .catch(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '';
            btn.disabled = false;
        });
    });
});
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
