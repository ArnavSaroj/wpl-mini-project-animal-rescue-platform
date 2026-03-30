<?php
session_start();
require_once './includes/db.php';

// If already logged in → redirect
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');;
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    } else {
        // Fetch user from DB
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Store session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? 'user';

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARGOS - Login</title>

    <!-- Global + Login styles -->
    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="./Styling/login.css">
</head>

<body>

<div class="login-wrapper">

    <div class="login-container">

        <!-- LEFT: ANIMAL -->
        <div class="login-left">
            <div class="login-text">
                <h2>Give Them a Home.</h2>
                <p>Your journey with a loyal companion starts here 🐾</p>
            </div>
        </div>

        <!-- RIGHT: LOGIN -->
        <div class="login-right">
            <div class="login-box">

                <!-- LOGO -->
                <div class="login-logo">
                    ARGOS<span class="dot">.</span>
                </div>

                <h2>Welcome Back</h2>
                <p class="login-subtext">Login to continue your journey</p>

                <?php if ($errors): ?>
                    <ul class="errors">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif; ?>

                <form method="post" action="login.php">
                    <input type="text" name="username" placeholder="Username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">Login</button>
                </form>

                <p style="text-align:center; margin-top:15px;">
                    Don’t have an account?
                    <a href="register.php" style="color: var(--primary); font-weight:600;">
                        Register
                    </a>
                </p>

            </div>
        </div>

    </div>

</div>

</body>
</html>
