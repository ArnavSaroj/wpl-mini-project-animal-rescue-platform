<?php
session_start();
require_once './includes/db.php';

// Fetch ALL pets (not just available)
$stmt = $pdo->query("SELECT * FROM pets");
$pets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARGOS | Adopt a Friend</title>

    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .adopt-page-header {
            padding: 120px 0 40px;
            text-align: center;
        }

        .badge.adopted {
            background: #7f8c8d;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .empty {
            text-align: center;
            margin-top: 40px;
            color: #777;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container">

        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>

        <ul class="nav-links">
            <li><a href="index.php#about">Our Story</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="adopt.php">Adopt</a></li>
            <li><a href="index.php#stats">Impact</a></li>
            <li><a href="index.php#stories">Stories</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php" class="btn-nav-cta">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="nav-login">Login</a></li>
                <li><a href="register.php" class="btn-nav-cta">Join Argos</a></li>
            <?php endif; ?>
        </ul>

    </div>
</nav>

<!-- MAIN -->
<main>
    <section class="adopt-page-header">
        <div class="container">
            <h1>Find Your New Best Friend</h1>
            <p>Choose a companion and give them a forever home 🐾</p>
        </div>
    </section>

    <section class="adopt-section">
        <div class="container">

            <?php if (empty($pets)): ?>
                <p class="empty">No pets available right now 🐾</p>
            <?php else: ?>

            <div class="pet-grid">
                <?php foreach ($pets as $pet): ?>
                    <div class="pet-card">

                        <div class="pet-image">
                            <img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet">

                            <?php if ($pet['status'] === 'adopted'): ?>
                                <span class="badge adopted">Adopted</span>
                            <?php endif; ?>
                        </div>

                        <div class="pet-info">
                            <h3><?= htmlspecialchars($pet['name']) ?></h3>

                            <p>
                                <?= htmlspecialchars($pet['type']) ?> |
                                <?= $pet['age'] ?> Years |
                                <?= htmlspecialchars($pet['gender']) ?>
                            </p>

                            <!-- BUTTON LOGIC -->
                            <?php if ($pet['status'] === 'adopted'): ?>

                                <button class="btn-view" disabled>Already Adopted</button>

                            <?php elseif (isset($_SESSION['user_id'])): ?>

                                <form method="post" action="adopt_pet.php"
                                      onsubmit="return confirm('Are you sure you want to adopt this pet?')">

                                    <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                                    <a href="pet.php?id=<?= $pet['id'] ?>" class="btn-view">View Profile</a>
                                    <button type="submit" class="btn-view">Adopt</button>
                                </form>

                            <?php else: ?>

                                <a href="login.php" class="btn-view">Login to Adopt</a>

                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php endif; ?>

        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 ARGOS Animal Rescue Platform.</p>
    </div>
</footer>

</body>
</html>
