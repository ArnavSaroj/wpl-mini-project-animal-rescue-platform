<?php
session_start();
require_once './includes/db.php';

/* TEMP ADMIN CHECK (simple) */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$stmt = $pdo->query("SELECT * FROM adoption_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM reports WHERE status != 'resolved' ORDER BY created_at DESC");
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <h2>Adoption Requests</h2>

    <?php foreach ($requests as $row): 
        $answers = json_decode($row['answers'], true);
    ?>
        <div style="border:1px solid #000; padding:10px; margin:10px;">
            <p><b>Pet ID:</b> <?= $row['pet_id'] ?></p>
            <p><b>User ID:</b> <?= $row['user_id'] ?></p>

            <p><b>Reason:</b> <?= $answers['reason'] ?? '' ?></p>
            <p><b>Experience:</b> <?= $answers['experience'] ?? '' ?></p>
            <p><b>Space/Time:</b> <?= $answers['space_time'] ?? '' ?></p>

            <a href="approve.php?id=<?= $row['id'] ?>">Approve</a> |
            <a href="reject.php?id=<?= $row['id'] ?>">Reject</a>
        </div>
    <?php endforeach; ?>

    <h2>Reports</h2>

<?php foreach ($reports as $r): ?>
    <div class="report-card">

        <div class="report-header">
            <h3><?= htmlspecialchars($r['description']) ?></h3>
            <span class="status <?= $r['status'] ?>">
                <?= ucfirst($r['status']) ?>
            </span>
        </div>

        <div class="report-info">
            <p><strong>📍 Location:</strong> <?= htmlspecialchars($r['location']) ?></p>
            <p><strong>📞 Contact:</strong> <?= htmlspecialchars($r['contact']) ?></p>
        </div>

        <?php if ($r['latitude'] && $r['longitude']): ?>
            <a class="map-link" target="_blank"
               href="https://www.google.com/maps?q=<?= $r['latitude'] ?>,<?= $r['longitude'] ?>">
                View on Map 📍
            </a>
        <?php endif; ?>

        <form method="post" action="update_report.php" class="status-form">
            <input type="hidden" name="id" value="<?= $r['id'] ?>">

            <select name="status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
            </select>

            <button class="btn-update">Update</button>
        </form>

    </div>
<?php endforeach; ?>

</div>

</body>
</html>
