<?php
require_once 'hoofd.php';
require_once 'middenpagina.php';
require_once 'voet.php';

require_once 'kenteken.php';
$kenteken = new kenteken();
$kenteken->verwijderOudeKentekens();
?>