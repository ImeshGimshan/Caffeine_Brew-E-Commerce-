<?php
include "connection.php";

$sql = "DELETE FROM cart";

if (mysqli_query($conn, $sql)) {
    header("Location: cart.php?status=cleared");
} else {
    echo "Error clearing cart: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
