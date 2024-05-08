<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Kentekens</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <style>
        
    </style>
</head>
<body>

<h1>Alle Kentekens</h1>

<?php
require_once 'beheerders.php';
require_once 'hoofd1.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}
// Schakel foutenrapportage in
error_reporting(E_ALL);
ini_set('display_errors', 1);

$beheerders = new Beheerders();
$allekentekens = $beheerders->getAlleKentekens();
?>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<div id="map" style="height: 500px;"></div>

<script>
    var map = L.map('map').setView([51.9286,4.5247], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var markers = L.markerClusterGroup();

    <?php foreach ($alleKentekens as $kenteken): ?>
    var marker = L.marker([<?php echo $kenteken['latitude']; ?>, <?php echo $kenteken['longitude']; ?>])
        .bindPopup('<b><?php echo $kenteken['titel']; ?></b><br><?php echo $kenteken['beschrijving']; ?>');

    markers.addLayer(marker);
    <?php endforeach; ?>

    map.addLayer(markers);
</script>

</body>
</html>
