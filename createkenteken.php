<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'kenteken.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kenteken = new Kenteken();
    $kentekenInfo = $kenteken->createKenteken($_POST['naam'], $_POST['kenteken'], $_POST['tijd'], $_POST['datum'], $_POST['bedrijf']);

    $message = "Kenteken succesvol toegevoegd. Kenteken ID: {$kentekenInfo['kentekenid']}";
    header("Location: index.php?message=" . urlencode($message));
    exit();
}
?>
