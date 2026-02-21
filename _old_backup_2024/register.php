<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class = "register-container">
        <form method="post">
            <h2>Register</h2>
            <input type="text" name="username" required placeholder="User Name" class="box"> 
            <input type="email" name="email" required placeholder="Enter your Email" class="box">
            <input type="password" name="password" required placeholder="Password" class="box">
            <input type="submit" name="register" value="Register Now" class="btn">
            <p> Already have an account? <a href="login.php">Login Now</a></p>
    </div>
</body>
</html>

<?php
    include ('connection.php');
    if(isset($_POST['register'])){
        $name = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $query = mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
        if($query){
            echo "<script>alert(Registration Successful)</script>";
        }
        else{
            echo "Error: ".mysqli_error($conn);
        }
    }
?>