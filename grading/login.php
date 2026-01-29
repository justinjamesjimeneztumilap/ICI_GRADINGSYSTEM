<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "grading");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $message = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: home.php");
            exit();
        } else {
            $message = "Invalid credentials!";
        }

        $stmt->close();
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
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="School Email" required>
        <input type="password" name="password" placeholder="Password (ID)" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
