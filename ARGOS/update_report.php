<?php
require_once './includes/db.php';

$id = $_POST['id'];
$status = $_POST['status'];

$stmt = $pdo->prepare("UPDATE reports SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

header("Location: admin.php");
exit;
