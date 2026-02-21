<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="addproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <section>
            <h3 class="heading">
                Add Products
            </h3>
            <form action="addproducts.php" method="post" class="addproduct" enctype="multipart/form-data">
                <input type="text" name="productname" placeholder="Product Name" required class="infield">
                <input type="text" name="productprice" placeholder="Product Price" min="0" required class="infield">
                <select name="category" class="infield" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Coffees">Coffees</option>
                    <option value="Buns">Buns</option>
                    <option value="Icecreams">Icecreams</option>
                    <option value="Cakes">Cakes</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Bubble Tea">Bubble Tea</option>
                    <option value="Juice">Juice</option>
                </select>
                <input type = "file" name = "productimage" required class="infield" accept="image/jpg,image/jpeg,image/png">
                <br>
                <input type="submit" value="Add Product" class="submit" name="addproduct">
            </form>

        </section>
    </div>
</body>
</html>

<!-- updated -->
<?php
    include 'connection.php';

    if (isset($_POST['addproduct'])) {
        // Retrieve and sanitize input data
        $productname = $_POST['productname'];
        $productprice = (float) $_POST['productprice'];
        $category = $_POST['category'];
        $productimage = $_FILES['productimage']['name'];
        $tempname = $_FILES['productimage']['tmp_name'];
        $productImgFolder = 'proImg/' . $productimage;

        // Validation for price
        if ($productprice <= 0) {
            echo "<script>alert('Invalid price. Please enter a positive number.');</script>";
        } else {
            // Insert query
            $insertquery = mysqli_query(
                $conn,
                "INSERT INTO products(name, price, category, img) VALUES('$productname', '$productprice', '$category', '$productimage')"
            ) or die("Failed to insert data into database");

            if ($insertquery) {
                // Move the uploaded image to the designated folder
                move_uploaded_file($tempname, $productImgFolder);
                $dismessage = "Product added successfully";
            } else {
                $dismessage = "Failed to insert product";
            }

            // Show success or failure message
            echo "<script>alert('$dismessage');</script>";
        }
    }
?>