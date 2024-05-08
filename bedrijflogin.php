<?php
session_start();

require_once 'hoofd.php';
require_once 'bedrijf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    $bedrijf = new bedrijf();
    $bedrijfid = $bedrijf->validatebedrijf($naam, $wachtwoord);

    if ($bedrijfid) {
        // Valid administrator, store the administrator ID in the session
        $_SESSION['bedrijfid'] = $bedrijfid;
        header("Location: bedrijfdashboard.php");
        exit();
    } else {

        $error = "Ongeldige inloggegevens. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Inloggen</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form action="bedrijflogin.php" method="post">
        <div class="mb-3">
            <label for="naam" class="form-label">naam:</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="mb-3">
            <label for="wachtwoord" class="form-label">Wachtwoord:</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>

    <p>Nog geen bedrijfsaccount? <a href="bedrijfregister.php">Registreer hier</a>.</p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
