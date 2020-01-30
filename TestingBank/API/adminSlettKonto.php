<?php
include_once 'apiAdminHeader.php';

$kontonummer = $_GET["kontonummer"];

$OK= $admin->slettKonto($kontonummer);
echo json_encode($OK);
 