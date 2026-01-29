<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, <?=htmlspecialchars($_SESSION['name'])?></h2>
<p>Role: <?=htmlspecialchars($_SESSION['role'])?></p>

<?php if($_SESSION['role'] == 'admin'): ?>
    <p><a href="#">Admin Panel (You can expand here)</a></p>
<?php endif; ?>

<a href="logout.php">Logout</a>
