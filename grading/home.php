<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];
$strand = $_SESSION['strand'] ?? null; // optional, in case strand not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Grading System</title>
    <style>
        /* Reset & base styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body {
            background: linear-gradient(135deg, #007BFF, #00BFFF);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card container */
        .dashboard-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 50px 60px;
            border-radius: 20px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 64px;
            letter-spacing: 3px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
        }

        p {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .strand {
            font-size: 20px;
            margin-top: 5px;
            color: #f0f0f0;
            opacity: 0.8;
        }

        a.logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #fff;
            color: #007BFF;
            font-weight: bold;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a.logout-btn:hover {
            background: #e0e0e0;
            transform: scale(1.05);
        }

        @media (max-width: 500px) {
            .dashboard-card {
                padding: 30px 20px;
            }
            h1 { font-size: 48px; }
            p { font-size: 18px; }
        }
    </style>
</head>
<body>

<div class="dashboard-card">
    <h1>WELCOME <?php echo strtoupper($role); ?>!</h1>
    <p>Hello, <?php echo htmlspecialchars($name); ?></p>
    <?php if($strand) echo "<p class='strand'>Strand: " . htmlspecialchars($strand) . "</p>"; ?>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
