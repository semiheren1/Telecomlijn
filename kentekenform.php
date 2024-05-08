<?php
require_once 'kenteken.php';
require_once 'hoofd.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Kentekenformulier</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-rSWY5G/6S2X8K2V5/6S2D/jJb8tcPfVugWCPtgaU8BwhBIJjNqcyzy3W6F5wEWTl"
          crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
</head>
<body>
<div class="container">
    <h2 class="mt-3">Kentekenformulier</h2>
    <form action="createkenteken.php" method="post" enctype="multipart/form-data">

<!--        <div class="mb-3">-->
<!--            <label for="titel" class="form-label">Titel:</label>-->
<!--            <select class="form-select" id="titel" name="titel" required>-->
<!--                <option value="omgewaaide_bomen">Omgewaaide Bomen</option>-->
<!--                <option value="kapotte_straatverlichting">Kapotte Straatverlichting</option>-->
<!--                <option value="zwerfvuil">Zwerfvuil</option>-->
<!--                <option value="anders">Anders</option>-->
<!--            </select>-->
<!--        </div>-->

        <div class="mb-3">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" class="form-control" id="naam" name="naam" required></input>
        </div>

        <div class="mb-3">
            <label for="kenteken" class="form-label">Kenteken:</label>
            <input class="form-control" id="kenteken" name="kenteken" required></input>
        </div>

        <div class="mb-3">
            <label for="bedrijf" class="form-label">Bedrijf:</label>
            <input class="form-control" id="bedrijf" name="bedrijf" required></input>
        </div>

        <div class="mb-3">
            <label for="datum" class="form-label">Datum:</label>
            <input type="date" class="form-control" id="datum" name="datum" required>
        </div>

        <div class="mb-3">
            <label for="tijd" class="form-label">Tijd:</label>
            <input type="time" class="form-control" id="tijd" name="tijd" required>
        </div>

<!--        <button type="button" class="btn btn-primary" onclick="requestLocationPermission()">Toestemming locatie</button>-->
        <input type="submit" class="btn btn-success" value="Verstuur kenteken">
    </form>

<!--    <div id="map" class="mt-3" style="height: 350px;"></div>-->
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
    var map = L.map('map').setView([0, 0], 2);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    function updateLocation(latitude, longitude) {
        var userLatLng = [latitude, longitude];
        map.setView(userLatLng, 15);

        L.marker(userLatLng).addTo(map)
            .bindPopup('Je bent hier!')
            .openPopup();

        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
    }

    function requestLocationPermission() {
        navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
            if (result.state === 'granted') {
                getCurrentLocation();
            } else if (result.state === 'prompt') {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        getCurrentLocation();
                    },
                    function (error) {
                        console.error("Error getting location:", error);
                    }
                );
            }
        });
    }

    function getCurrentLocation() {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                updateLocation(latitude, longitude);
            },
            function (error) {
                console.error("Error getting location:", error);
            }
        );
    }
</script>
<?php
require_once 'voet.php';
?>
</body>
</html>
