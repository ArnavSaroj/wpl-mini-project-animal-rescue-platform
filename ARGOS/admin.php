<?php
session_start();
require_once './includes/db.php';

/* TEMP ADMIN CHECK (simple) */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

/* Fetch reports */
$stmt = $pdo->query("SELECT * FROM reports ORDER BY created_at DESC");
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel | ARGOS</title>
    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="./Styling/admin.css">
</head>

<body>

<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>
    </div>
</nav>

<div class="admin-container">

    <h1>Admin Panel 🛠️</h1>

    <div class="admin-add-pet">

        <h2>Add New Pet 🐾</h2>

        <form method="post" action="add_pet.php" class="add-pet-form">

            <div class="form-grid">
                <input type="text" name="name" placeholder="Pet Name" required>
                <input type="text" name="type" placeholder="Type (Dog/Cat)" required>

                <input type="number" name="age" placeholder="Age" required>
                <input type="text" name="gender" placeholder="Gender" required>

                <input type="text" name="image" placeholder="Image URL">
            </div>

            <textarea name="description" placeholder="Description"></textarea>

            <button class="btn-main">Add Pet</button>

        </form>
    </div>

    <?php foreach ($reports as $r): ?>
        <div class="report-card">

            <p><strong>Description:</strong> <?= htmlspecialchars($r['description']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($r['location']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($r['contact']) ?></p>

            <p class="status">Status: <?= $r['status'] ?></p>

            <?php if ($r['image']): ?>
                <img src="<?= htmlspecialchars($r['image']) ?>">
            <?php endif; ?>

            <?php if ($r['latitude'] && $r['longitude']): ?>
                <p>
                    <a target="_blank"
                       href="https://www.google.com/maps?q=<?= $r['latitude'] ?>,<?= $r['longitude'] ?>">
                        View on Map 📍
                    </a>
                </p>
            <?php endif; ?>

            <!-- STATUS UPDATE -->
            <form method="post" action="update_report.php">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">

                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>

                <button class="btn-main">Update</button>
            </form>

        </div>
    <?php endforeach; ?>

</div>

</body>
</html>
