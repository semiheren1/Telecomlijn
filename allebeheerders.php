<?php
session_start();
require_once 'hoofd1.php';
require_once 'beheerders.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

$beheerders = new Beheerders();
$alleBeheerders = $beheerders->getAlleBeheerders();
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

<h2>Beheerders</h2>

<table id="kentekenTable">
    <tr>
        <th>Beheerder ID</th>
        <th>Gebruikersnaam</th>
        <th>Wachtwoord</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Email</th>
        <th>Acties</th>


    </tr>

    <?php foreach ($alleBeheerders as $beheerder): ?>
        <tr class="beheerderRow" data-beheerderid="<?php echo $beheerder['beheerderid']; ?>">
            <td><?php echo $beheerder['beheerderid']; ?></td>
            <td><?php echo $beheerder['gebruikersnaam']; ?></td>
            <td><?php echo $beheerder['wachtwoord']; ?></td>
            <td><?php echo $beheerder['voornaam']; ?></td>
            <td><?php echo $beheerder['achternaam']; ?></td>
            <td><?php echo $beheerder['email']; ?></td>
            <td>
                <button id="tabelButton" onclick="editBeheerder(<?php echo $beheerder['beheerderid']; ?>)">Bewerken</button>
                <button id="tabelButton" onclick="deleteBeheerder(<?php echo $beheerder['beheerderid']; ?>)">Verwijderen</button>

            </td>

        </tr>
    <?php endforeach; ?>

    <script>
        function editBeheerder(beheerderid) {
            window.location.href = 'bewerkenBeheerder.php?beheerderid=' + beheerderid;
        }

        function deleteBeheerder(beheerderid) {
            if (confirm('Weet je zeker dat je deze beheerder wilt verwijderen?')) {
                // Send AJAX request to delete_beheerder.php
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'verwijderBeheerder.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // Reload the page after successful deletion
                        window.location.reload();
                    } else {
                        alert('Er is een probleem opgetreden bij het verwijderen van de beheerder.');
                    }
                };
                xhr.send('beheerderid=' + beheerderid);
            }
        }
    </script>


</table>
<!---->
<!--<button id="kentekenButton" onclick="window.location.href='allekentekens.php'">Zie alle kentekens</button>-->
<!---->
<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', function () {-->
<!--        var rows = document.getElementsByClassName('kentekenRow');-->
<!--        Array.from(rows).forEach(function (row) {-->
<!--            row.addEventListener('click', function () {-->
<!--                var kentekenId = this.getAttribute('data-kentekenid');-->
<!--                window.location.href = 'searchkenteken1.php?kentekenid=' + kentekenId;-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->

</body>
</html>
