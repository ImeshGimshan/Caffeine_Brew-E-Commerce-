<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
<div class = "reservation-container">
        <form method="post">
            <h2>Make a Reservation</h2>
            <input type="text" name="name" required placeholder="Enter your name" class="box"> 
            <input type="text" name="tele" required placeholder="Enter your number" class="box">
            <input type="pax" name="pax" required placeholder="How many people ? " class="box">
            <input type="date" name="date" required class="box">
            <input type="submit" name="book" value="Book Now" class="btn">
    </div>
</body>
</html>

<?php 
    include ('connection.php'); 
    if(isset($_POST['book'])){
        $name =$_POST['name'];
        $tele = $_POST['tele'];
        $pax = $_POST['pax'];
        $date = $_POST['date'];
        $query = mysqli_query($conn, "INSERT INTO reservation (name, tele, pax, date) VALUES ('$name', '$tele', '$pax', '$date')");
        if($query){
            echo "<script> alert('Thank You for your reservation !'); </script>";
        }
        else{
            echo "Error: ".mysqli_error($conn);
        }
    }
?>