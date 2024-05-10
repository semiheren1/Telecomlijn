<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'bedrijf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $bedrijf = new bedrijf();
    $bedrijfInfo = $bedrijf->createBedrijf($_POST['naam'], $_POST['email'], $_POST['adres'], $_POST['postcode'], $_POST['wachtwoord']);

    $message = "Bedrijf succesvol toegevoegd. Kenteken ID: {$bedrijfInfo['bedrijfid']}";
    header("Location: index.php?message=" . urlencode($message));
    exit();
}
?>
