<?php
include "connection.php";

// Check if the product ID is passed
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // SQL query to delete the item from the cart table
    $sql = "DELETE FROM cart WHERE cid = $product_id";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the cart page with a success message
        header("Location: cart.php?status=removed");
    } else {
        echo "Error removing item: " . mysqli_error($conn);
    }
} else {
    // Redirect to the cart page if no product ID is provided
    header("Location: cart.php");
}

mysqli_close($conn);
?>
