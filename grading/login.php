<?php
require 'db.php'; 

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
<html>
<head>
    <title>Login - Grading System</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f0f2f5; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }
        .login-box { 
            background: #fff; 
            padding: 30px; 
            border-radius: 10px; 
            width: 350px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .login-box h2 {
            margin-bottom: 20px;
        }
        .login-box img {
            width: 80px;
            margin-bottom: 15px;
        }
        input { 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] { 
            background: #007BFF; 
            color: #fff; 
            border: none; 
            cursor: pointer; 
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .message { 
            color: red; 
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>
<div class="login-box">
    <img src="https://lh5.googleusercontent.com/proxy/_pYvYMNVADwNNbK_cvy-QFr4R3-7XGRO_rziYiMJbXvFAOuQIDlrX5dP4b4zxIASRQyCfHcOyx_Y9CNOAkC6" alt="Logo">
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
