<?php
    $conn=mysqli_connect("localhost","root","","caffienebrewdb");
    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }
?>