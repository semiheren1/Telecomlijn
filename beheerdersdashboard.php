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
            margin: 0;
            padding: 0;
            background-color: white;
        }

        #container {
            text-align: center;
            position: relative;
            min-height: 95vh;
            margin-top: 200px; /* Ruimte toegevoegd bovenaan voor de navbar */
        }

        #search-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px; /* Ruimte toegevoegd onder de afbeelding */
        }

        #postcard-container {
            position: absolute;
            bottom: 250px; /* Afstand tussen de postcards en de onderkant */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .postcard {
            width: 200px;
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
<div id="container">
    <img id="search-image" src="gemeentefoto.jpg" alt="Zoekafbeelding">
    <div id="postcard-container">
        <div class="postcard">
            <h2><a href="kentekensBeheerder.php">Kentekens</a></h2>
            <p></p>
        </div>

        <div class="postcard">
            <h2><a href="bedrjivenBeheerder.php.php">Bedrijven</a></h2>
            <p></p>
        </div>

        <div class="postcard">
            <h2><a href="allebeheerders.php">Beheerders</a></h2>
            <p></p>
        </div>
    </div>
</div>


</body>
</html>
