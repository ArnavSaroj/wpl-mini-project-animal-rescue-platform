<?php
require_once './includes/db.php';

$name = $_POST['name'];
$type = $_POST['type'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$image = $_POST['image'];
$description = $_POST['description'];

$stmt = $pdo->prepare("
    INSERT INTO pets (name, type, age, gender, image, description)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([$name, $type, $age, $gender, $image, $description]);

header("Location: admin.php");
exit;
