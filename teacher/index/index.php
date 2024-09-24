<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Welcome to the Drop Application Management System</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="/app/views/user/profile.php">Go to Profile</a>
        <a href="/app/controllers/logout.php">Logout</a>
    <?php else: ?>
        <a href="/app/views/user/login.php">Login</a>
        <a href="/app/views/user/register.php">Register</a>
    <?php endif; ?>
    <a href="/app/views/application/form.php">View Drop Applications</a>
</body>
</html>
