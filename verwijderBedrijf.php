<?php
session_start();
require_once 'bedrijf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bedrijfid'])) {
    $bedrijf = new Bedrijf();
    $bedrijfid = $_POST['bedrijfid'];

    if ($bedrijf->verwijderBedrijf($bedrijfid)) {
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
