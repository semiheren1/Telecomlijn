<?php
session_start();
require_once 'hoofd1.php';

require_once 'kenteken.php';

// Check if kentekenid is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['kentekenid'])) {
    $kentekenid = $_GET['kentekenid'];
    $kentekens = new Kenteken();
    $kenteken = $kentekens->zoekKentekenOpId($kentekenid);

    if (!$kenteken) {
        // Kenteken not found, handle error (redirect or display error message)
        echo "Kenteken niet gevonden.";
        exit();
    }
} else {
    // Redirect to appropriate page if kentekenid is missing
    header("Location: kentekensBeheerder.php");
    exit();
}


// Handle form submission for updating kenteken details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $kentekenid = $_POST['kentekenid'];
    $naam = $_POST['naam'];
    $kenteken = $_POST['kenteken'];
    $tijd = $_POST['tijd'];
    $datum = $_POST['datum'];
    $bedrijf = $_POST['bedrijf'];


        // Update kenteken details in the database
    $kentekens = new kenteken() ;
    if ($kentekens->updateKenteken($kentekenid, $naam, $kenteken, $tijd, $datum, $bedrijf)) {
            header("Location: kentekensBeheerder.php"); // Redirect back to dashboard after successful update
            exit();
        } else {
            $error = "Er is een fout opgetreden bij het bijwerken van het kenteken.";
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
    <h2 class="text-center mb-4">Kenteken bewerken</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="row g-3">
        <input type="hidden" name="kentekenid" value="<?php echo htmlspecialchars($kentekenid); ?>">

        <div class="col-md-6">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" id="naam" name="naam" class="form-control" value="<?php echo $kenteken['naam']; ?>" required>
        </div>


        <div class="col-md-6">
            <label for="kenteken" class="form-label">Kenteken:</label>
            <input type="text" id="kenteken" name="kenteken" class="form-control" value="<?php echo $kenteken['kenteken']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="tijd" class="form-label">Tijd:</label>
            <input type="time" id="tijd" name="tijd" class="form-control" value="<?php echo $kenteken['tijd']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="datum" class="form-label">Datum:</label>
            <input type="date" id="datum" name="datum" class="form-control" value="<?php echo $kenteken['datum']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="Bedrijf" class="form-label">Bedrijf:</label>
            <input type="text" id="bedrijf" name="bedrijf" class="form-control" value="<?php echo $kenteken['bedrijf']; ?>" required>
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
