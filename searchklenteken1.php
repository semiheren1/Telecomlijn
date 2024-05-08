<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenteken Details</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>

<h1>Kentekens</h1>

<?php
require_once 'beheerders.php';
require_once 'hoofd1.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['kentekenid'])) {
    $kentekenid = $_GET['kentekenid'];

    $beheerders = new Beheerders();
    $gevondenKenteken = $beheerders->zoekKentekenOpId($kentekenid);

    if ($gevondenKenteken) {
        echo "Kenteken ID: " . $gevondenKenteken['kentekenid'] . "<br>";
        echo "Titel: " . $gevondenKenteken['titel'] . "<br>";
        echo "Beschrijving: " . $gevondenKenteken['beschrijving'] . "<br>";
        echo "Datum: " . $gevondenKenteken['datum'] . "<br>";
        echo "E-mail: " . $gevondenKenteken['Email'] . "<br>";

        echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
        echo '<div id="map" style="height: 400px;"></div>';
        echo '<script>
                        var map = L.map("map").setView([' . $gevondenKenteken['latitude'] . ', ' . $gevondenKenteken['longitude'] . '], 13);
                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            attribution: "© OpenStreetMap contributors"
                        }).addTo(map);
                        L.marker([' . $gevondenKenteken['latitude'] . ', ' . $gevondenKenteken['longitude'] . ']).addTo(map)
                            .bindPopup("Locatie van de kenteken");
                    </script>';

        echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var kentekenIdInput = document.getElementById("kentekenid");
                            kentekenIdInput.value = ' . $gevondenKenteken['kentekenid'] . ';
                            document.getElementById("searchForm").submit();
                        });
                    </script>';
    } else {
        echo "Geen kenteken gevonden met het opgegeven ID.";
    }
}
?>

<form id="searchForm" action="searchkenteken.php" method="GET">
    <label for="kentekenid">Voer kenteken ID in:</label>
    <input type="text" id="kentekenid" name="kentekenid">
    <input type="submit" value="Zoeken">
</form>

</body>
</html>