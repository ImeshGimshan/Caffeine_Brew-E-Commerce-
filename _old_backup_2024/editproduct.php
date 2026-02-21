<?php
include 'connection.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details based on the product ID
    $stmt = $conn->prepare("SELECT * FROM products WHERE pid = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>
        <!-- Display product details in an editable form -->
        <form action="updateproduct.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['pid']; ?>">
            <label for="name">Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="price">Price</label>
            <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
            <label for="img">Image</label>
            <input type = "file" name = "img" required class="infield" accept="image/jpg,image/jpeg,image/png" value="<?php echo htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit">Update Product</button>
        </form>
        <?php
    } else {
        echo "<script>alert('Product not found!');</script>";
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updateproducts</title>
    <link rel="stylesheet" href="editproduct.css">
</head>
<body>
    
</body>
</html>
