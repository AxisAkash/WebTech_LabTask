<?php
require_once "config.php";

$error = "";
$savedEmail = $_COOKIE["user_email"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Email and password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password_hash"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            // Save previous last login before updating it
            $_SESSION["previous_last_login"] = $_COOKIE["last_login"] ?? "This is your first login.";

            // Store email in cookie for auto-filling login form
            setcookie("user_email", $user["email"], [
                'expires' => time() + (30 * 24 * 60 * 60),
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => false,
                'samesite' => 'Lax'
            ]);

            // Store current login time
            setcookie("last_login", date("Y-m-d H:i:s"), [
                'expires' => time() + (30 * 24 * 60 * 60),
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => false,
                'samesite' => 'Lax'
            ]);

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Email</label>
        <input 
            type="email" 
            name="email" 
            value="<?= htmlspecialchars($savedEmail) ?>" 
            required
        >

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>
        Do not have an account?
        <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>