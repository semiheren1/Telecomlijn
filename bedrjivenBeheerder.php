<?php
session_start();
require_once 'hoofd1.php';
require_once 'bedrijf.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

$bedrijven = new Bedrijf();
$alleBedrijven = $bedrijven->getAlleBedrijven();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Beheerdersdashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            cursor: pointer;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: lightseagreen;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .tabelButton {
            margin-top: 5px;
            padding: 5px;
            border: none;
            background-color: lightseagreen;
        }

        #container {
            text-align: center;
            margin-top: 5%; /* Ruimte toegevoegd bovenaan voor de navbar */
            margin-left: 24%;
        }

        #postcard-container {
            bottom: 250px; /* Afstand tussen de postcards en de onderkant */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .postcard {
            width: 400px;
            padding: 20px;
            border: 3px solid lightseagreen;
            border-radius: 15px;
            background-color: white;
            color: lightseagreen;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .postcard a {
            text-decoration: none;
            color: lightseagreen;
        }

    </style>
</head>
<body>

<h2>Bedrijven</h2>

<table id="kentekenTable">
    <tr>
        <th>Bedrjif ID</th>
        <th>naam</th>
        <th>email</th>
        <th>adres</th>
        <th>Postcode</th>
        <th>Wachtwoord</th>
        <th>Acties</th>


    </tr>

    <?php foreach ($alleBedrijven as $bedrijf): ?>
        <tr class="bedrijfRow" data-bedrijfid="<?php echo $bedrijf['bedrijfid']; ?>">
            <td><?php echo $bedrijf['bedrijfid']; ?></td>
            <td><?php echo $bedrijf['naam']; ?></td>
            <td><?php echo $bedrijf['email']; ?></td>
            <td><?php echo $bedrijf['adres']; ?></td>
            <td><?php echo $bedrijf['postcode']; ?></td>
            <td><?php echo $bedrijf['wachtwoord']; ?></td>
            <td>
                <button class="tabelButton" onclick="editBedrijf(<?php echo $bedrijf['bedrijfid']; ?>)">Bewerken</button>
                <button class="tabelButton" onclick="deleteBedrijf(<?php echo $bedrijf['bedrijfid']; ?>)">Verwijderen</button>

            </td>

        </tr>
    <?php endforeach; ?>

    <script>
        function editBedrijf(bedrijfid) {
            window.location.href = 'bewerkenBedrijf.php?bedrijfid=' + bedrijfid;
        }

        function deleteBedrijf(bedrijfid) {
            console.log('Deleting bedrijf with ID:', bedrijfid);

            if (confirm('Weet je zeker dat je dit bedrijf wilt verwijderen?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'verwijderBedrijf.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        console.log('Bedrijf successfully deleted');
                        // Reload the page after successful deletion
                        window.location.reload();
                    } else {
                        console.error('Error deleting bedrijf:', xhr.statusText);
                        alert('Er is een probleem opgetreden bij het verwijderen van het bedrijf.');
                    }
                };
                xhr.send('bedrijfid=' + bedrijfid);
            }
        }


    </script>


</table>

<div id="container">
    <div id="postcard-container">
        <div class="postcard">
            <h2><a href="bedrijfForm.php">Bedrijf Aanmaken</a></h2>
            <p></p>
        </div>
    </div>
</div>
</body>
</html>
