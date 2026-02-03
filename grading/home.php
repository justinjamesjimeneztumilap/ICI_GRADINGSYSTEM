<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$name = $_SESSION['name'];

if ($role === 'student') {
    $bg = "linear-gradient(135deg, #1abc9c, #3498db)";
    $badge = "STUDENT";
    $cards = ["My Grades", "Subjects", "Profile"];
} elseif ($role === 'teacher') {
    $bg = "linear-gradient(135deg, #2ecc71, #27ae60)";
    $badge = "TEACHER";
    $cards = ["Encode Grades", "My Classes", "Students"];
} else { 
    $bg = "linear-gradient(135deg, #000, #222)";
    $badge = "ADMINISTRATOR";
    $cards = ["Manage Users", "Subjects", "System Settings"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home | Grading System</title>
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: <?= $bg ?>;
    color: white;
    animation: fadeIn 1s ease;
}
.header {
    padding: 30px;
    text-align: center;
}
.badge {
    background: rgba(255,255,255,0.2);
    padding: 8px 16px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 10px;
}
.container {
    padding: 40px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}
.card {
    background: rgba(255,255,255,0.15);
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-8px);
}
.logout {
    text-align: center;
    margin: 30px;
}
.logout a {
    background: #e74c3c;
    padding: 12px 25px;
    color: white;
    text-decoration: none;
    border-radius: 10px;
}
@keyframes fadeIn {
    from {opacity:0; transform: translateY(20px);}
    to {opacity:1;}
}
</style>
</head>
<body>

<div class="header">
    <h1>Welcome, <?= $name; ?></h1>
    <div class="badge"><?= $badge ?></div>
</div>

<div class="container">
    <?php foreach ($cards as $c): ?>
        <div class="card"><?= $c ?></div>
    <?php endforeach; ?>
</div>

<div class="logout">
    <a href="logout.php">Logout</a>
</div>

</body>
</html>