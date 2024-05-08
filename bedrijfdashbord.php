<?php
session_start();
require_once 'hoofd1.php';
require_once 'bedrijf.php';

if (!isset($_SESSION['bedrijfid'])) {
    header("Location: bedrijflogin.php");
    exit();
}

$bedrijf = new bedrijf();
$recenteKenteken = $bedrijf->getRecenteKenteken();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>bedrijfdashboard</title>
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
        <th>Naam</th>
        <th>Kenteken</th>
        <th>Tijd</th>
        <th>Datum</th>
        <th>Bedrijf</th>

    </tr>
    
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
