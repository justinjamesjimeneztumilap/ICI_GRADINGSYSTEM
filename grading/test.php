<?php
$connection = new mysqli("localhost", "root", "", "grading");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo "MySQLi is working!";
?>
