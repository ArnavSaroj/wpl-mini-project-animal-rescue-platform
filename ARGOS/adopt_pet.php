<?php
session_start();
require_once './includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$pet_id = $_POST['pet_id'] ?? null;

if ($pet_id) {
    // Insert adoption
    $stmt = $pdo->prepare("INSERT INTO adoptions (user_id, pet_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $pet_id]);

    // Mark pet as adopted
    $stmt = $pdo->prepare("UPDATE pets SET status = 'adopted' WHERE id = ?");
    $stmt->execute([$pet_id]);
}

header("Location: adopt.php");
exit;
