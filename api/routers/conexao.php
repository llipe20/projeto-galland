<?php 
    $serve = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'galland';
    $conn = mysqli_connect($serve, $user, $password, $database);
    
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>