<?php
session_start();
require_once 'kenteken.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kentekenid'])) {
    $kenteken = new kenteken();
    $kentekenid = $_POST['kentekenid'];

    if ($kenteken->verwijderKenteken($kentekenid)) {
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
