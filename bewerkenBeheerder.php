<?php
session_start();
require_once 'hoofd1.php';

require_once 'beheerders.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['beheerderid'])) {
    $beheerderid = $_GET['beheerderid'];
    $beheerders = new Beheerders();
    $beheerder = $beheerders->zoekBeheerderOpId($beheerderid);

    if (!$beheerder) {
        // Administrator not found, handle error (redirect or display error message)
        echo "Beheerder niet gevonden.";
        exit();
    }
}

// Handle form submission for updating administrator details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $beheerderid = $_POST['beheerderid'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    // Validate old password
    $beheerders = new Beheerders();
    $storedPassword = $beheerders->zoekWachtwoordOpId($beheerderid); // Retrieve hashed password from database
    if (!password_verify($oldPassword, $storedPassword)) {
        $error = "Ongeldig oud wachtwoord. Probeer het opnieuw.";
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update administrator details in the database
        if ($beheerders->updateBeheerder($beheerderid, $gebruikersnaam, $hashedPassword, $voornaam, $achternaam, $email)) {
            header("Location: beheerdersdashboard.php"); // Redirect back to dashboard after successful update
            exit();
        } else {
            $error = "Er is een fout opgetreden bij het bijwerken van de beheerder.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheerder bewerken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Beheerder bewerken</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="row g-3">
        <input type="hidden" name="beheerderid" value="<?php echo $beheerderid; ?>">

        <div class="col-md-6">
            <label for="gebruikersnaam" class="form-label">Gebruikersnaam:</label>
            <input type="text" id="gebruikersnaam" name="gebruikersnaam" class="form-control" value="<?php echo $beheerder['gebruikersnaam']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="old_password" class="form-label">Oud wachtwoord:</label>
            <input type="password" id="old_password" name="old_password" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="new_password" class="form-label">Nieuw wachtwoord:</label>
            <input type="password" id="new_password" name="new_password" class="form-control">
        </div>

        <div class="col-md-6">
            <label for="voornaam" class="form-label">Voornaam:</label>
            <input type="text" id="voornaam" name="voornaam" class="form-control" value="<?php echo $beheerder['voornaam']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="achternaam" class="form-label">Achternaam:</label>
            <input type="text" id="achternaam" name="achternaam" class="form-control" value="<?php echo $beheerder['achternaam']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $beheerder['email']; ?>" required>
        </div>

        <div class="col-12 mt-4">
            <button type="submit" name="submit" class="btn btn-success" style="background-color: lightseagreen;">Opslaan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
