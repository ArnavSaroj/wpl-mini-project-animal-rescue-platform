<?php
session_start();
require_once './includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'] ?? '';
    $desc = $_POST['description'] ?? '';
    $lat = $_POST['latitude'] ?? null;
    $lng = $_POST['longitude'] ?? null;
    $location = $_POST['location'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $report_type = $_POST['report_type'] ?? '';

    $stmt = $pdo->prepare("
        INSERT INTO reports 
        (title, description, location, contact, report_type, latitude, longitude, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $title,
        $desc,
        $location,
        $contact,
        $report_type,
        $lat,
        $lng
    ]);

    echo "<script>alert('Report submitted successfully!'); window.location='report.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Pet | ARGOS</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <!-- Your existing styles -->
    <link rel="stylesheet" href="./Styling/style.css">

    <style>
body {
    background: #f5f6fa;
    font-family: Arial, sans-serif;
}

.report-container {
    max-width: 900px;   /* wider */
    margin: 100px auto;
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.report-container h2 {
    
    margin-bottom: 20px;
    font-size: 24px;
}

input, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

input, textarea, select {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

textarea {
    height: 100px;
    resize: none;
}

#map {
    height: 400px;   /* FIXED */
    width: 100%;
    margin-top: 15px;
    border-radius: 12px;
}

.coords {
    margin-top: 10px;
    font-size: 14px;
    color: #666;
}

.btn-submit {
    margin-top: 20px;
    background: #ff7a00;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    font-size: 15px;
}

.btn-submit:hover {
    background: #e66d00;
}
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>
    </div>
</nav>

<div class="report-container">

    <h2 style="text-align:left; margin-top: 10px;">Report a Pet 🐾</h2>

    <form method="POST">

        <input type="text" name="title" placeholder="Title" required>

        <textarea name="description" placeholder="Describe the situation..." required></textarea>

        <input type="text" name="location" placeholder="Location (e.g. XYZ Colony)" required>

        <input type="text" name="contact" placeholder="Your Contact Number" required>

        <select name="report_type" required>
            <option value="">Select Report Type</option>
            <option value="lost">Lost Pet</option>
            <option value="found">Injured Animal</option>
            <option value="found">Found Animal</option>
        </select>

        <!-- Hidden -->
        <input type="hidden" name="latitude" id="lat">
        <input type="hidden" name="longitude" id="lng">

        <div id="map"></div>

        <p class="coords" id="coords">Click on map to select location</p>

        <button class="btn-submit">Submit Report</button>

    </form>

</div>

<!-- Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([19.0760, 72.8777], 12);
let marker;

// Load map
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

// Fix rendering issue
setTimeout(() => {
    map.invalidateSize();
}, 100);

// Click to select location
map.on('click', function(e) {

    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker(e.latlng).addTo(map);

    document.getElementById('lat').value = e.latlng.lat;
    document.getElementById('lng').value = e.latlng.lng;

    document.getElementById('coords').innerText =
        "Selected: " + e.latlng.lat.toFixed(5) + ", " + e.latlng.lng.toFixed(5);
});
</script>

</body>
</html>
