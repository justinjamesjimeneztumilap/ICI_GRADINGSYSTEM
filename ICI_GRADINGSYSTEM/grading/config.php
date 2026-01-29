<?php
session_start();

$host = "localhost";  // XAMPP MySQL host
$dbname = "imdb";     // Your existing DB name
$user = "root";       // XAMPP MySQL user
$pass = "";           // XAMPP MySQL password (usually empty)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
