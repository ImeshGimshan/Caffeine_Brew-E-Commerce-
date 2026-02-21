<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id'];
    $new_quantity = $_POST['quantity'];

    // Update the quantity in the database
    $update_query = "UPDATE cart SET quantity = $new_quantity WHERE cid = $product_id";
    mysqli_query($conn, $update_query);

    // Get the product price to calculate the new total price
    $select_query = "SELECT price FROM cart WHERE cid = $product_id";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);

    $new_total_price = $row['price'] * $new_quantity;

    // Return the new total price to the client
    echo $new_total_price;
}
?>
