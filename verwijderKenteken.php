<?php
session_start();
require_once 'kenteken.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kentekenid'])) {
    $kentekenid = $_POST['kentekenid'];

    $kentekens = new Kenteken(); // Correct class instantiation
    if ($kentekens->verwijderKenteken($kentekenid)) {
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
