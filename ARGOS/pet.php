<?php
session_start();
require_once './includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: adopt.php");
    exit;
}

// Fetch pet
$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->execute([$id]);
$pet = $stmt->fetch();

if (!$pet) {
    header("Location: adopt.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pet['name']) ?> | ARGOS</title>

    <link rel="stylesheet" href="./Styling/style.css">

    <style>
        .pet-details-container {
            padding: 120px 0;
        }

        .pet-details-card {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .pet-details-image img {
            width: 400px;
            height: 100%;
            object-fit: cover;
        }

        .pet-details-info {
            padding: 30px;
        }

        .pet-details-info h2 {
            font-family: 'Montserrat', sans-serif;
        }

        .badge.adopted {
            background: #7f8c8d;
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>
    </div>
</nav>

<section class="pet-details-container">
    <div class="pet-details-card">

        <div class="pet-details-image">
            <img src="<?= htmlspecialchars($pet['image']) ?>">
        </div>

        <div class="pet-details-info">
            <?php if ($pet['status'] === 'adopted'): ?>
                <span class="badge adopted">Adopted</span>
            <?php endif; ?>

            <h2><?= htmlspecialchars($pet['name']) ?></h2>

            <p><strong>Type:</strong> <?= htmlspecialchars($pet['type']) ?></p>
            <p><strong>Age:</strong> <?= $pet['age'] ?> years</p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($pet['gender']) ?></p>

            <p style="margin-top:15px;">
                <?= htmlspecialchars($pet['description']) ?>
            </p>

            <br>

            <?php if ($pet['status'] === 'adopted'): ?>
                <button class="btn-view" disabled>Already Adopted</button>

            <?php elseif (isset($_SESSION['user_id'])): ?>
                <form method="post" action="adopt_pet.php">
                    <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                    <button class="btn-view">Adopt</button>
                </form>

            <?php else: ?>
                <a href="login.php" class="btn-view">Login to Adopt</a>
            <?php endif; ?>

        </div>

    </div>
</section>

</body>
</html>
