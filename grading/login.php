<?php
require 'db.php';
session_start();

// Database connection
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'grading';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $user_password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($user_password)) {
        $message = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            $message = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($user_password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: home.php");
                    exit();
                } else {
                    $message = "Invalid credentials!";
                }
            } else {
                $message = "Invalid credentials!";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Grading System</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>  
<div class="login-box">
    <img src="https://lh5.googleusercontent.com/proxy/_pYvYMNVADwNNbK_cvy-QFr4R3-7XGRO_rziYiMJbXvFAOuQIDlrX5dP4b4zxIASRQyCfHcOyx_Y9CNOAkC6" alt="Logo">
    <h2>Grading System Login</h2>
    <?php if($message) echo "<p class='message'>" . htmlspecialchars($message) . "</p>"; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="School Email" required>
        <input type="password" name="password" placeholder="Password (ID)" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
