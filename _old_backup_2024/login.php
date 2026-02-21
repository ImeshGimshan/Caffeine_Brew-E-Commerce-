<?php
    include ("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class = "login-container">
        <form method="post">
            <h2>Login</h2>
            <input type="text" name="username" required placeholder="User Name" class="box"> 
            <input type="password" name="password" required placeholder="Password" class="box">
            <input type="submit" name="login" value="Login" class="btn">
            <p class="link"> Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
    
</body>
</html>

<?php
    if (isset($_POST["login"])) {
        $name = $_POST["username"];
        $password = md5($_POST["password"]);
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
        $stmt->bind_param("ss", $name, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["id"] = $row["id"];
            header("location: main-page.html");
            exit();
        } else {
            echo "<script>alert('Invalid username or password')</script>";
        }
        $stmt->close();
    }    
?>

