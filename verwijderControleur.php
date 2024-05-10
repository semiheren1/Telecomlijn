<?php
session_start();
require_once 'controleur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['controleurid'])) {
    $controleur = new controleur();
    $controleurid = $_POST['controleurid'];

    if ($controleur->verwijderControleur($controleurid)) {
        // Return a success response
        http_response_code(200);
        exit();
    } else {
        // Return an error response
        http_response_code(500);
        exit();
    }
}
?>
