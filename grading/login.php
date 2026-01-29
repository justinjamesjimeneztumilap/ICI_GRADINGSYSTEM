<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<?php
require 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $message = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id, name, role FROM users WHERE email = ? AND password = ?"
        );
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            header("Location: home.php");
            exit();
        } else {
            $message = "Invalid credentials!";
        }

        $stmt->close();
    }
}
?>

<title>Login | Grading System</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

body {
    height: 100vh;
    display: flex;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
}


.left-panel {
    flex: 1;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    animation: slideLeft 1s ease;
}

.left-panel h1 {
    font-size: 48px;
    margin-bottom: 15px;
}

.left-panel p {
    font-size: 18px;
    max-width: 400px;
    opacity: 0.9;
}


.right-panel {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    width: 420px;
    padding: 40px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    text-align: center;
    animation: fadeUp 1.2s ease;
}

.login-box img {
    width: 90px;
    margin-bottom: 15px;
}

.login-box h2 {
    color: #fff;
    margin-bottom: 5px;
}

.login-box p {
    color: #ddd;
    margin-bottom: 20px;
}

.login-box input {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
    font-size: 15px;
}

.login-box input[type="submit"] {
    background: #1e90ff;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.login-box input[type="submit"]:hover {
    background: #187bcd;
    transform: translateY(-2px);
}

.message {
    color: #ffb3b3;
    margin-bottom: 10px;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideLeft {
    from {
        opacity: 0;
        transform: translateX(-80px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
</head>

<body>

<div class="left-panel">
    <h1>Grading System</h1>
    <p>Manage students, grades, and academic records with ease.</p>
</div>

<div class="right-panel">
    <div class="login-box">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
        <h2>Welcome Back</h2>
        <p>Login to continue</p>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="LOGIN">
        </form>
    </div>
</div>

</body>
</html>
