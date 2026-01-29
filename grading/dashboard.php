<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
    <p>Your role: <strong><?php echo htmlspecialchars($role); ?></strong></p>

    <?php if($role === 'admin'): ?>
        <p><a href="#">Admin Panel</a></p>
    <?php elseif($role === 'teacher'): ?>
        <p><a href="#">Teacher Panel</a></p>
    <?php else: ?>
        <p><a href="#">Student Panel</a></p>
    <?php endif; ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
