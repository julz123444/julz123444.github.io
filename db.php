<?php
$servername = "localhost";  // Typically localhost for XAMPP
$username = "root";         // Default username for MySQL in XAMPP
$password = "";             // Default password is empty for XAMPP
$dbname = "rotc_db";        // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
