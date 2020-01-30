<?php
include_once 'apiAdminHeader.php';

$konto = new konto();
$konto->personnummer = $_POST["personnummer"];
$konto->kontonummer  = $_POST["kontonummer"];
$konto->type         = $_POST["type"];
$konto->saldo        = $_POST["saldo"];
$konto->valuta       = $_POST["valuta"];

$OK= $admin->endreKonto($konto);
echo json_encode("OK");
 