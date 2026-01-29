<?php
require 'config.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = "SELECT * FROM users WHERE email='$email'";
    $res = $conn->query($check);
    if ($res->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name','$email','$password','student')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Register</h2>
<?php if($message) echo "<p class='error'>$message</p>"; ?>
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Register">
</form>
<p><a href="login.php">Login</a></p>
</body>
</html>
