<?php
session_start();
require_once 'hoofd1.php';
require_once 'bedrijf.php';

// Check if 'bedrijfid' is provided via GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['bedrijfid'])) {
    $bedrijfid = $_GET['bedrijfid'];

    // Instantiate bedrijf object
    $bedrijven = new bedrijf();

    // Retrieve bedrijf details by ID
    $bedrijf = $bedrijven->zoekBedrijfOpId($bedrijfid);

    if (!$bedrijf) {
        // Bedrijf not found, handle error
        echo "Bedrijf niet gevonden.";
        exit();
    }
}

// Handle form submission for updating bedrijf details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $bedrijfid = $_POST['bedrijfid'];
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $adres = $_POST['adres'];
    $postcode = $_POST['postcode'];

    // Instantiate bedrijf object
    $bedrijven = new bedrijf();

    // Update bedrijf details
    if ($bedrijven->updateBedrijf($bedrijfid, $naam, $email, $adres, $postcode)) {
        header("Location: beheerdersdashboard.php");
        exit();
    } else {
        $error = "Er is een fout opgetreden bij het bijwerken van het bedrijf.";
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
        <input type="hidden" name="bedrijfid" value="<?php echo $bedrijfid; ?>">

        <div class="col-md-6">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" id="naam" name="naam" class="form-control" value="<?php echo $bedrijf['naam']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $bedrijf['email']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="adres" class="form-label">adres:</label>
            <input type="text" id="adres" name="adres" class="form-control" value="<?php echo $bedrijf['adres']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="postcode" class="form-label">postcode:</label>
            <input type="postcode" id="postcode" name="postcode" class="form-control" value="<?php echo $bedrijf['postcode']; ?>" required>
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
