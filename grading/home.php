<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Grading System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }
        .container {
            background: #fff;
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            text-align: center;
            margin-bottom: 20px;
        }
        a {
            display: block;
            text-align: center;
            color: #fff;
            background: #007BFF;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
    <p>Role: <?php echo htmlspecialchars($role); ?></p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
