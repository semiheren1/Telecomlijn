<?php
session_start();
require_once 'hoofd1.php';
require_once 'bedrijf.php';

// Foutrapportage inschakelen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Controleer of de bedrijf is ingelogd
if (!isset($_SESSION['bedrijfid'])) {
    header("Location: bedrijflogin.php");
    exit();
}

// Haal de huidige bedrijfgegevens op
$bedrijf = new bedrijf();
$bedrijfid = $_SESSION['bedrijfid'];
$huidigebedrijf = $bedrijf->zoekbedrijfOpId($bedrijfid);

// Controleer of het formulier is verzonden via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of alle vereiste velden zijn ingevuld
    if (isset($_POST['nieuweVoornaam'], $_POST['nieuweAchternaam'], $_POST['nieuweEmail'], $_POST['nieuwenaam'], $_POST['nieuwWachtwoord'])) {
        // Voer de updates uit
        $nieuweVoornaam = $_POST['nieuweVoornaam'];
        $nieuweAchternaam = $_POST['nieuweAchternaam'];
        $nieuweEmail = $_POST['nieuweEmail'];
        $nieuwenaam = $_POST['nieuwenaam'];
        $nieuwWachtwoord = $_POST['nieuwWachtwoord'];

        // Update voornaam
        $updateVoornaamResult = $bedrijf->updatebedrijfVoornaam($bedrijfid, $nieuweVoornaam);
        if ($updateVoornaamResult !== true) {
            echo "Voornaam bijwerken mislukt: " . $updateVoornaamResult;
        }

        // Update achternaam
        $updateAchternaamResult = $bedrijf->updatebedrijfAchternaam($bedrijfid, $nieuweAchternaam);
        if ($updateAchternaamResult !== true) {
            echo "Achternaam bijwerken mislukt: " . $updateAchternaamResult;
        }

        // Update e-mail
        $updateEmailResult = $bedrijf->updatebedrijfEmail($bedrijfid, $nieuweEmail);
        if ($updateEmailResult !== true) {
            echo "E-mail bijwerken mislukt: " . $updateEmailResult;
        }

        // Update naam
        $updatenaamResult = $bedrijf->updatebedrijfnaam($bedrijfid, $nieuwenaam);
        if ($updatenaamResult !== true) {
            echo "naam bijwerken mislukt: " . $updatenaamResult;
        }

        // Update wachtwoord
        $updateWachtwoordResult = $bedrijf->updatebedrijfWachtwoord($bedrijfid, $nieuwWachtwoord);
        if ($updateWachtwoordResult !== true) {
            echo "Wachtwoord bijwerken mislukt: " . $updateWachtwoordResult;
        }

        // Vernieuw de bedrijfgegevens
        $huidigebedrijf = $bedrijf->zoekbedrijfOpId($bedrijfid);
    } else {
        echo "Vul alle vereiste velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bedrijfprofiel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">bedrijfprofiel</h1>

    <form method="post" action="bedrijfsprofiel.php">
        <div class="mb-3">
            <label for="nieuweVoornaam" class="form-label">Nieuwe voornaam:</label>
            <input type="text" id="nieuweVoornaam" name="nieuweVoornaam" class="form-control" value="<?php echo $huidigebedrijf['voornaam']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nieuweAchternaam" class="form-label">Nieuwe achternaam:</label>
            <input type="text" id="nieuweAchternaam" name="nieuweAchternaam" class="form-control" value="<?php echo $huidigebedrijf['achternaam']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nieuweEmail" class="form-label">Nieuwe e-mail:</label>
            <input type="email" id="nieuweEmail" name="nieuweEmail" class="form-control" value="<?php echo $huidigebedrijf['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nieuwenaam" class="form-label">Nieuwe naam:</label>
            <input type="text" id="nieuwenaam" name="nieuwenaam" class="form-control" value="<?php echo $huidigebedrijf['naam']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nieuwWachtwoord" class="form-label">Nieuw wachtwoord:</label>
            <input type="password" id="nieuwWachtwoord" name="nieuwWachtwoord" class="form-control" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success btn-lg" style="background-color: lightseagreen;">Opslaan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
