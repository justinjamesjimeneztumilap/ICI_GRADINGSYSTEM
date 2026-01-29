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
        // Prepare statement: login by email + password
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect to home page
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
<html>
<head>
    <title>Login - Grading System</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #fff; padding: 20px; border-radius: 10px; width: 350px; box-shadow: 0 0 10px rgba(0,0,0,0.2);}
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;}
        input[type="submit"] { background: #007BFF; color: #fff; border: none; cursor: pointer; }
        .message { color: red; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="School Email" required>
        <input type="password" name="password" placeholder="Password (ID)" required>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
