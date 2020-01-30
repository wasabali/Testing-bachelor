<?php
include_once 'apiAdminHeader.php';

$personnummer = $_GET["personnummer"];

$OK= $admin->slettKunde($personnummer);
echo json_encode("OK");
 