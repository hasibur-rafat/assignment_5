<?php
session_start();

if ($_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
</head>
<body>
    <h2>User Page</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?></p>
</body>
</html>