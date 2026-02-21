<?php
include 'connection.php';

if (isset($_POST['product_id'])) {
    // Retrieve and sanitize input data
    $product_id = $_POST['product_id'];
    $productname = $_POST['name'];
    $productprice = (float) $_POST['price'];
    $new_image = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name'];
    $productImgFolder = 'proImg/' . $new_image;

    // Validate price
    if ($productprice <= 0) {
        echo "<script>alert('Invalid price. Please enter a positive number.');</script>";
    } else {
        // Fetch current image name for deletion check if new image is uploaded
        $currentImageQuery = $conn->prepare("SELECT img FROM products WHERE pid = ?");
        $currentImageQuery->bind_param("i", $product_id);
        $currentImageQuery->execute();
        $result = $currentImageQuery->get_result();

        if ($result->num_rows > 0) {
            $currentImage = $result->fetch_assoc()['img'];

            // Update query
            $updatequery = $conn->prepare("UPDATE products SET name = ?, price = ?, img = ? WHERE pid = ?");
            $updatequery->bind_param("sdsi", $productname, $productprice, $new_image, $product_id);

            if ($updatequery->execute()) {
                // Move the uploaded image to the designated folder
                move_uploaded_file($tempname, $productImgFolder);

                // Optionally, delete the old image from the folder if a new one is uploaded
                if ($new_image !== $currentImage) {
                    unlink('proImg/' . $currentImage);
                }

                // Redirect to manage products page
                header("Location: manageproducts.php");
                echo "<script>alert('Updated the product sucessfully !');</script>";
                exit(); // Don't forget to call exit() after header to prevent further execution
            } else {
                echo "<script>alert('Failed to update product');</script>";
            }
        } else {
            echo "<script>alert('Product not found');</script>";
        }

        $currentImageQuery->close();
        $updatequery->close();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="updateproduct.css">
</head>
<body>
    
</body>
</html>
