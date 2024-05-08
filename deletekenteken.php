<?php
require_once 'kenteken.php';
require_once 'hoofd1.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['kentekenid'])) {
        $kentekenid = $_GET['kentekenid'];

        // Maak een nieuw Kenteken object
        $kentekens = new Kenteken();

        // Roep de deleteKenteken functie aan om de kenteken te verwijderen
        $kentekens->deleteKenteken($kentekenid);

        // Redirect naar een andere pagina of geef een succesbericht weer
        header("Location: allekentekens.php");
        exit();
    }
}
?>

