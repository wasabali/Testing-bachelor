<?php
include_once 'apiAdminHeader.php';

$konto = new konto();
$konto->personnummer = $_POST["personnummer"];
$konto->kontonummer = $_POST["kontonummer"];
$konto->saldo = 0;
$konto->type = $_POST["type"];
$konto->valuta = $_POST["valuta"];
$OK= $admin->registrerKonto($konto);
echo json_encode($OK);
 