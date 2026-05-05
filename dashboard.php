<?php
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION["user_name"];
$previousLastLogin = $_SESSION["previous_last_login"] ?? ($_COOKIE["last_login"] ?? "No previous login found.");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Dashboard</h2>

    <p>Welcome, <strong><?= htmlspecialchars($userName) ?></strong>!</p>

    <p>
        Last login:
        <strong><?= htmlspecialchars($previousLastLogin) ?></strong>
    </p>

    <a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>