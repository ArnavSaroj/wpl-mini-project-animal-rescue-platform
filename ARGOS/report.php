<?php
session_start();
require_once './includes/db.php';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $contact = trim($_POST['contact']);
    $user_id = $_SESSION['user_id'] ?? null;

    // ✅ FIX: define lat/lng safely
    $lat = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
    $lng = !empty($_POST['longitude']) ? $_POST['longitude'] : null;

    $imagePath = null;

    // Image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }

        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Insert into DB
    $stmt = $pdo->prepare("
        INSERT INTO reports (user_id, description, location, contact, image, latitude, longitude)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $user_id,
        $description,
        $location,
        $contact,
        $imagePath,
        $lat,
        $lng
    ]);

    $success = "Report submitted successfully 🚑";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Rescue | ARGOS</title>

    <link rel="stylesheet" href="./Styling/style.css">

    <style>
        .report-container {
            padding: 120px 0;
            max-width: 600px;
            margin: auto;
        }

        .report-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .report-box textarea,
        .report-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }

        .errors {
            color: red;
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

<section class="report-container">
    <div class="report-box">

        <h2>Report an Animal in Need 🚑</h2>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <?php if ($errors): ?>
            <ul class="errors">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <textarea name="description" placeholder="Describe the situation..." required></textarea>

            <input type="text" name="location" placeholder="Location (area, landmark)">

            <input type="text" name="contact" placeholder="Your contact number">

            <!-- IMAGE -->
            <input type="file" name="image">

            <!-- LOCATION -->
            <input type="text" name="latitude" placeholder="Latitude (optional)">
            <input type="text" name="longitude" placeholder="Longitude (optional)">

            <button class="btn-main">Submit Report</button>
        </form>

    </div>
</section>

</body>
</html>
