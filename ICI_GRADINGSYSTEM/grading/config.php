<?php
session_start();

$host = "localhost";
$dbname = "grading";   // your existing database
$user = "root";        // XAMPP default or your Codespace MySQL user
$pass = "";            // XAMPP default password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
