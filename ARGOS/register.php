<?php
session_start();
require_once './includes/db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);

    if ($stmt->fetch()) {
        $errors[] = "Username or email already exists.";
    }

    // Insert user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        $success = "Account created successfully! You can now login.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARGOS - Register</title>

    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="./Styling/login.css">
</head>

<body>

<div class="login-wrapper">

    <div class="login-container">

        <!-- LEFT (IMAGE) -->
        <div class="login-left">
            <div class="login-text">
                <h2>Start Saving Lives.</h2>
                <p>Join ARGOS and help animals find their forever home 🐾</p>
            </div>
        </div>

        <!-- RIGHT (FORM) -->
        <div class="login-right">
            <div class="login-box">

                <div class="login-logo">
                    ARGOS<span class="dot">.</span>
                </div>

                <h2>Create Account</h2>
                <p class="login-subtext">Be part of something meaningful</p>

                <?php if ($errors): ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif; ?>

                <?php if ($success): ?>
                    <p style="color: green; text-align:center; margin-bottom:15px;">
                        <?= $success ?>
                    </p>
                <?php endif; ?>

                <form method="post" action="register.php">
                    <input type="text" name="username" placeholder="Username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

                    <input type="email" name="email" placeholder="Email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">Register</button>
                </form>

                <p style="text-align:center; margin-top:15px;">
                    Already have an account?
                    <a href="login.php" style="color: var(--primary); font-weight:600;">Login</a>
                </p>

            </div>
        </div>

    </div>

</div>

</body>
</html>
