<?php
session_start();

require_once 'bedrijf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    $bedrijf = new bedrijf();
    $bedrijfid = $bedrijf->validatebedrijf($naam, $wachtwoord);

    if ($bedrijfid) {
        // Geldige bedrijf, sla de bedrijfid op in de sessie
        $_SESSION['bedrijfid'] = $bedrijfid;
        header("Location: bedrijfsdashboard.php");
        exit();
    } else {
        // Ongeldige inloggegevens
        $error = "Ongeldige inloggegevens. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>bedrijfpagina - Inloggen</title>
</head>
<body>
<h2>Inloggen</h2>
<?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
<form action="bedrijfpagina.php" method="post">
    naam: <input type="text" name="naam" required><br>
    Wachtwoord: <input type="password" name="wachtwoord" required><br>
    <input type="submit" value="Inloggen">
</form>
</body>
</html>

