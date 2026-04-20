<?php
require_once './includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request ID");
}

// Get request details safely
$stmt = $pdo->prepare("SELECT * FROM adoption_requests WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Request not found");
}

$pet_id = $row['pet_id'];
$user_id = $row['user_id'];

// Approve request
$stmt = $pdo->prepare("UPDATE adoption_requests SET status = 'approved' WHERE id = ?");
$stmt->execute([$id]);

// Insert into adoptions
$stmt = $pdo->prepare("INSERT INTO adoptions (user_id, pet_id) VALUES (?, ?)");
$stmt->execute([$user_id, $pet_id]);

// Mark pet as adopted
$stmt = $pdo->prepare("UPDATE pets SET status = 'adopted' WHERE id = ?");
$stmt->execute([$pet_id]);

header("Location: admin.php");
exit;
?>
