<?php
session_start();
require_once 'hoofd1.php';
require_once 'beheerders.php';
require_once 'kenteken.php';


if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

$kentekens = new Kenteken();
$recenteKentekens = $kentekens->getRecenteKentekens();
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

        #tabelButton {
            margin-top: 5px;
            padding: 5px;
            border: none;
            background-color: lightseagreen;
        }
    </style>
</head>
<body>

<h2>Kentekens</h2>

<table id="kentekenTable">
    <tr>
        <th>Kenteken ID</th>
        <th>Naam</th>
        <th>Kenteken</th>
        <th>Tijd</th>
        <th>Datum</th>
        <th>Bedrijf</th>
        <th>Acties</th>


    </tr>


    <?php foreach ($recenteKentekens as $kenteken): ?>
        <tr class="kentekenRow" data-kentekenid="<?php echo $kenteken['kentekenid']; ?>">
            <td><?php echo $kenteken['kentekenid']; ?></td>
            <td><?php echo $kenteken['naam']; ?></td>
            <td><?php echo $kenteken['kenteken']; ?></td>
            <td><?php echo $kenteken['tijd']; ?></td>
            <td><?php echo $kenteken['datum']; ?></td>
            <td><?php echo $kenteken['bedrijf']; ?></td>
            <td>
                <button id="tabelButton" onclick="editKenteken(<?php echo $kenteken['kentekenid']; ?>)">Bewerken</button>
                <button id="tabelButton" onclick="deleteKenteken(<?php echo $kenteken['kentekenid']; ?>)">Verwijderen</button>
            </td>

        </tr>
    <?php endforeach; ?>
    <script>
        function editKenteken(kentekenid) {
            window.location.href = 'bewerkenKenteken.php?kentekenid=' + kentekenid;
        }


        function deleteKenteken(kentekenid) {
            if (confirm('Weet je zeker dat je dit kenteken wilt verwijderen?')) {
                // Send AJAX request to delete_kenteken.php
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'verwijderKenteken.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // Reload the page after successful deletion
                        window.location.reload();
                    } else {
                        alert('Er is een probleem opgetreden bij het verwijderen van het kenteken.');
                    }
                };
                xhr.send('kentekenid=' + kentekenid);
            }
        }
    </script>
</table>

</body>
</html>
