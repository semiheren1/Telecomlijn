<?php
session_start();
require_once 'hoofd1.php';
require_once 'beheerders.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

$beheerders = new Beheerders();
$recenteKentekens = $beheerders->getRecenteKentekens();
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

        #kentekenButton {
            margin-top: 20px;
            padding: 10px;
            background-color: lightseagreen;
        }
    </style>
</head>
<body>
<h2>5 recente Kenetekens</h2>

<table id="kentekenTable">
    <tr>
        <th>Kenteken ID</th>
        <th>Titel</th>
        <th>Beschrijving</th>
        <th>Datum</th>
        <th>Email</th>
        <th>Latitude</th>
        <th>Longitude</th>

    </tr>


    <?php foreach ($recenteKentekens as $kenteken): ?>
        <tr class="kentekenRow" data-kentekenid="<?php echo $kenteken['kentekenid']; ?>">
            <td><?php echo $kenteken['kentekenid']; ?></td>
            <td><?php echo $kenteken['titel']; ?></td>
            <td><?php echo $kenteken['beschrijving']; ?></td>
            <td><?php echo $kenteken['datum']; ?></td>
            <td><?php echo $kenteken['Email']; ?></td>
            <td><?php echo $kenteken['latitude']; ?></td>
            <td><?php echo $kenteken['longitude']; ?></td>

        </tr>
    <?php endforeach; ?>
</table>

<button id="kentekenButton" onclick="window.location.href='allekentekens.php'">Zie alle kentekens</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.getElementsByClassName('kentekenRow');
        Array.from(rows).forEach(function (row) {
            row.addEventListener('click', function () {
                var kentekenId = this.getAttribute('data-kentekenid');
                window.location.href = 'searchkenteken1.php?kentekenid=' + kentekenId;
            });
        });
    });
</script>

</body>
</html>
