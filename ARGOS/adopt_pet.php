<?php
session_start();
require_once './includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get pet ID from GET or POST
$pet_id = $_POST['pet_id'] ?? $_GET['id'] ?? null;

if (!$pet_id) {
    die("Invalid Pet ID");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $q1 = trim($_POST['q1'] ?? '');
    $q2 = trim($_POST['q2'] ?? '');
    $q3 = trim($_POST['q3'] ?? '');

    // Validate (extra safety)
    if ($q1 === '' || $q2 === '' || $q3 === '') {
        echo "<p style='color:red;'>All fields are required!</p>";
    } else {

        $answers = json_encode([
            "reason" => $q1,
            "experience" => $q2,
            "space_time" => $q3
        ]);

        // Insert into DB
        $stmt = $pdo->prepare("
            INSERT INTO adoption_requests (pet_id, user_id, answers)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$pet_id, $user_id, $answers]);

        // Show success + answers
        echo "<h2>Request Submitted Successfully!</h2>";

        echo "<h3>Your Answers:</h3>";

        echo "<p><b>Why adopt?</b><br>" . htmlspecialchars($q1) . "</p>";
        echo "<p><b>Experience:</b><br>" . htmlspecialchars($q2) . "</p>";
        echo "<p><b>Space & Time:</b><br>" . htmlspecialchars($q3) . "</p>";

        echo "<br><a href='adopt.php'>Go Back</a>";

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adopt Pet</title>
</head>
<body>

<h2>Adopt Pet</h2>

<form method="POST">

    <!-- IMPORTANT: preserve pet id -->
    <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet_id) ?>">

    <h3>Adoption Questions</h3>

    <label>Why do you want to adopt this pet?</label><br>
    <textarea name="q1" required></textarea><br><br>

    <label>Do you have prior experience with pets?</label><br>
    <textarea name="q2" required></textarea><br><br>

    <label>Do you have enough space and time for the pet?</label><br>
    <textarea name="q3" required></textarea><br><br>

    <button type="submit">Submit Request</button>

</form>

</body>
</html>
