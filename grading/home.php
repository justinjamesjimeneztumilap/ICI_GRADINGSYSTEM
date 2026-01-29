<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home - Grading System</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="home-body">
<div class="header">
    <img src="https://lh5.googleusercontent.com/proxy/_pYvYMNVADwNNbK_cvy-QFr4R3-7XGRO_rziYiMJbXvFAOuQIDlrX5dP4b4zxIASRQyCfHcOyx_Y9CNOAkC6" alt="Logo">
    <h1>Grading System</h1>
</div>

<div class="container">
    <div class="welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </div>

    <div class="card">
        <h3>Dashboard</h3>
        <p>Access your grading system features here.</p>
        <a href="grades.php" class="btn">Go to Grades</a>
    </div>

    <div class="card">
        <h3>Profile</h3>
        <p>Manage your account information and settings.</p>
        <a href="profile.php" class="btn">View Profile</a>
    </div>

    <a href="logout.php" class="btn logout">Logout</a>
</div>
</body>
</html>
