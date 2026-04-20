<?php
require_once './includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request");
}

// ✅ Using PDO (same as rest of your project)
$stmt = $pdo->prepare("UPDATE adoption_requests SET status = 'rejected' WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin.php");
exit;
?>
