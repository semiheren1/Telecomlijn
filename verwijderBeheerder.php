<?php
session_start();
require_once 'beheerders.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['beheerderid'])) {
    $beheerders = new Beheerders();
    $beheerderid = $_POST['beheerderid'];

    if ($beheerders->verwijderBeheerder($beheerderid)) {
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
