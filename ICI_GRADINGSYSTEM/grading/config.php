<?php
session_start();

$host = "localhost";
$dbname = "grading";   // your existing database
$user = "root";        // your MySQL username (default in XAMPP is root)
$pass = "";            // your MySQL password (default is empty)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
