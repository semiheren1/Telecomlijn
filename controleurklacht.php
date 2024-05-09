<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'controleurs.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Afbeelding verwerken als deze is geüpload
    if ($_FILES['afbeelding']['error'] == 4) {
        // Er is geen afbeelding geüpload, doe hier wat je nodig hebt of laat het leeg
        $afbeelding = null;
    } elseif ($_FILES['afbeelding']['error'] !== UPLOAD_ERR_OK) {
        echo "Er is een fout opgetreden bij het uploaden van de afbeelding: " . $_FILES['afbeelding']['error'];
        exit();
    } else {
        $uploadDirectory = 'uploads/';
        $uploadedFile = $uploadDirectory . basename($_FILES['afbeelding']['name']);

        if (move_uploaded_file($_FILES['afbeelding']['tmp_name'], $uploadedFile)) {
            $afbeelding = $uploadedFile;
        } else {
            echo "Er is een fout opgetreden bij het uploaden van de afbeelding.";
            exit();
        }
    }

    $controleur = new controleur();
    $controleurInfo = $controleur->controleur($_POST['naam'], $_POST['kenteken'], $_POST['tijd'],$_POST['datum'],$_POST['bedrijf'],$_POST['beschrijving'], $longitude, $latitude, $afbeelding);

    $message = "kenteken succesvol toegevoegd. kenteken ID: {$controleurInfo['kentekenid']} Latitude: {$controleurInfo['latitude']} Longitude: {$controleurInfo['longitude']}";
    header("Location: controleurklacht.php?message=" . urlencode($message));
    exit();
}

