<?php
session_start();

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once './includes/db.php';

// Get user data (optional for future use)
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT pets.* 
    FROM pets 
    JOIN adoptions ON pets.id = adoptions.pet_id
    WHERE adoptions.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$adoptedPets = $stmt->fetchAll();

$stmt = $pdo->prepare("
    SELECT * FROM reports WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ARGOS</title>

    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="./Styling/dashboard.css">
</head>

<body>

<!-- NAVBAR (reuse your existing one style) -->
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="adopt.php">Adopt</a></li>
            <li><a href="logout.php" class="btn-nav-cta">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- DASHBOARD -->
<section class="dashboard">
    <div class="dashboard-container">

        <div class="dashboard-header">
            <h1>Welcome, <?= htmlspecialchars($user['username']) ?> 👋</h1>
            <p>Here’s your activity and saved information.</p>
        </div>

        <!-- USER INFO -->
        <div class="card">
            <h3>Your Info</h3>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Joined:</strong> <?= $user['created_at'] ?></p>
        </div>

        

        <!-- ADOPTION SECTION (EMPTY FOR NOW) -->
        <div class="card">
            <h3>Your Adopted Pets 🐾</h3>

            <?php if ($adoptedPets): ?>
                <div class="pet-grid">

                <?php foreach ($adoptedPets as $pet): ?>
                    <div class="pet-card">
                        <div class="pet-image">
                            <img src="<?= htmlspecialchars($pet['image']) ?>">
                            <span class="badge adopted">Adopted</span>
                        </div>

                        <div class="pet-info">
                            <h3><?= htmlspecialchars($pet['name']) ?></h3>
                            <p><?= htmlspecialchars($pet['type']) ?></p>

                            <a href="pet.php?id=<?= $pet['id'] ?>" class="btn-view">
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

                </div>

            <?php else: ?>
                <p class="empty">You haven’t adopted any pets yet.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3>Your Reports 🚑</h3>

            <?php if ($reports): ?>
                <?php foreach ($reports as $r): ?>
                    <p>
                        <?= htmlspecialchars($r['description']) ?>
                        — <strong><?= $r['status'] ?></strong>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty">No reports submitted yet.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

</body>
</html>
