<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="manageproducts.css"> 
</head>
<body>
    
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="admin-dashboard.html">
            <img src="img/logo.png" alt="Logo" class="navbar-logo">
            <span class="brand-name">Caffeine Brew</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="addproducts.php">Add Products</a></li>
                <li class="nav-item"><a class="nav-link " href="manageproducts.php">Manage Products</a></li>
                <li class="nav-item"><a class="nav-link " href="reservationdetails.php">Reservation Details</a></li>
 
            </ul>
        </div>
    </nav>
        <!-- Banner Section -->
        <section class="banner-section text-center">
            <div class="banner-content">
                <h1>Manage Products</h1>
            </div>
        </section>
    
        <section class="menu-section container my-5">
    <div class="row">
       
   
    
    <?php
include 'connection.php';

// SQL query to fetch all products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
    // Loop through all products and display them
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-card">';
        echo '<img src="proImg/' . $row['img'] . '" alt="' . $row['name'] . '" class="product-image">';
        echo '<h3 class="product-name">' . $row['name'] . '</h3>';
        echo '<p class="product-price">' . "$" . $row['price'] . '</p>';
        // Add a form with a hidden input for the product name
        echo '<form action="manageproducts.php" method="POST">';
        echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '">';
        echo '<button type="submit" class="delete-button"><i class="fas fa-trash"></i></button>';
        echo '</form>';
        

        echo '<form action="editproduct.php" method="GET">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['pid'], ENT_QUOTES, 'UTF-8') . '">';
        echo '<button type="submit" class="edit-button"><i class="fas fa-edit"></i></button>'; // Ensure product ID is used
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "<script>alert('No products found!');</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];

    // Prepare the SQL delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE name = ?");
    $stmt->bind_param("s", $product_name);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully'); window.location.href='manageproducts.php';</script>";
    } else {
        echo "<script>alert('Failed to delete product');</script>";
    }

    $stmt->close();
}


// Close the database connection
mysqli_close($conn);
?>




<div class="product-card"></div>

</body>
</html>