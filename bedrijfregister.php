<?php
require_once 'bedrijf.php';
require_once 'hoofd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $adres = $_POST['adres'];
    $postcode = $_POST['postcode'];
    $wachtwoord = $_POST['wachtwoord'];

    $bedrijf = new bedrijf();

    // Check if the username is already in use for administrators
    if (!$bedrijf->naamInGebruikVoorbedrijf($naam)) {
        // Check if the email address has the correct domain
        if (endsWith($email, "@urbanindustries.nl")) {
            // Attempt to create the administrator
            if ($bedrijf->create($naam, $email, $adres, $postcode, $wachtwoord)) {
                header("Location: bedrijflogin.php?success=1"); // Redirect to login with success flag
                exit();
            } else {
                $message = "Registratie mislukt. Probeer het opnieuw.";
            }
        } else {
            $message = "Registratie mislukt. Vraag hulp bij werkgever.";
        }
    } else {
        $message = "Deze naam is al in gebruik. Kies een andere.";
    }
}

function endsWith($haystack, $needle) {
    return substr($haystack, -strlen($needle)) === $needle;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registratiepagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h2>Registratie</h2>
    <?php if (isset($message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="bedrijfregister.php" method="post">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="adres" class="form-label">Adres:</label>
            <input type="text" class="form-control" id="adres" name="adres" required>
        </div>
        <div class="mb-3">
            <label for="postcode" class="form-label">Postcode:</label>
            <input type="text" class="form-control" id="postcode" name="postcode" required>
        </div>
        <div class="mb-3">
            <label for="wachtwoord" class="form-label">Waxhtwoord:</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <button type="submit" class="btn btn-lightseagreen">Registreren</button>
    </form>
</div>
</body>
</html>
