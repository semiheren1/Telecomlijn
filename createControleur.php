<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'controleur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $controleur = new controleur();
    $controleurInfo = $controleur->createControleur($_POST['email'], $_POST['wachtwoord']);

    $message = "controleur succesvol toegevoegd. controleur ID: {$controleurInfo['controleurid']}";
    header("Location: index.php?message=" . urlencode($message));
    exit();
}
?>
