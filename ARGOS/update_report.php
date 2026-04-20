<?php
require_once './includes/db.php';

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id || !$status) {
    die("Invalid request");
}

// Update status
$stmt = $pdo->prepare("UPDATE reports SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

header("Location: admin.php");
exit;
?>
