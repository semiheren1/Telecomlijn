<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Kentekens</title>
    <!-- Voeg de Leaflet CSS toe -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Optioneel: Voeg aanvullende CSS toe voor de kaartcontainer -->
    <style>
        #map {
            height: 400px;
        }

        /* Voeg deze CSS-stijlen toe voor de button */
        form {
            margin-top: 20px;
        }

        button {
            background-color: lightseagreen;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: lightseagreen;
        }
    </style>
</head>
<body>

<div id="content" class="content">
    <h1>Kenteken Details</h1>

    <?php
    require_once 'hoofd1.php';
    require_once 'beheerders.php';

    if (!isset($_SESSION['beheerderid'])) {
        header("Location: beheerderlogin.php");
        exit();
    }

    if (isset($_GET['kentekenid'])) {
        $kentekenid = $_GET['kentekenid'];

        $beheerders = new Beheerders();
        $gevondenKenteken = $beheerders->zoekKentekenOpId($kentekenid);

        if ($gevondenKenteken) {
            // Toon de gevonden kentekengegevens
            echo "Kenteken ID: " . $gevondenKenteken['kentekenid'] . "<br>";
            echo "Titel: " . $gevondenKenteken['titel'] . "<br>";
            echo "Beschrijving: " . $gevondenKenteken['beschrijving'] . "<br>";
            echo "Datum: " . $gevondenKenteken['datum'] . "<br>";
            echo "E-mail: " . $gevondenKenteken['Email'] . "<br>";

            // Voeg de Leaflet JavaScript toe
            echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
            // Voeg de kaartcontainer toe
            echo '<div id="map" style="height: 400px;"></div>';
            // Voeg JavaScript toe om de kaart te initialiseren
            echo '<script>
                        var map = L.map("map").setView([' . $gevondenKenteken['latitude'] . ', ' . $gevondenKenteken['longitude'] . '], 13);
                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            attribution: "© OpenStreetMap contributors"
                        }).addTo(map);

                        var marker = L.marker([' . $gevondenKenteken['latitude'] . ', ' . $gevondenKenteken['longitude'] . '])
                            .bindPopup("<b>' . $gevondenKenteken['titel'] . '</b><br>' . $gevondenKenteken['beschrijving'] . '")
                            .addTo(map);
                    </script>';


            echo '<form action="deletekenteken.php" method="GET">
                      <input type="hidden" name="kentekenid" value="' . $gevondenKenteken['kentekenid'] . '">
                      <button type="submit">Verwijder Kenteken</button>
                  </form>';
        } else {
            echo "Geen kenteken gevonden met het opgegeven ID.";
        }
    } else {
        echo "Geen kenteken ID opgegeven.";
    }
    ?>
</div>

</body>
</html>
