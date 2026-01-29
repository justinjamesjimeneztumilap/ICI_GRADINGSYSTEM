<?php
// Start session (optional if you want session in multiple files)
session_start();

// Database connection settings
$servername = "localhost";  // MySQL server
$username = "root";         // Default XAMPP MySQL username
$password = "";             // Default XAMPP MySQL password (empty by default)
$dbname = "grading";        // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
