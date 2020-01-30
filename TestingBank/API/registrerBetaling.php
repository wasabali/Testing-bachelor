<?php
include_once 'apiBankHeader.php';

$transaksjon = new transaksjon();
$transaksjon->fraTilKontonummer = $_POST["tilKonto"];
$transaksjon->dato = $_POST["dato"];
$transaksjon->belop = $_POST["belop"];
$transaksjon->melding = $_POST["melding"];
$kontoNr = $_POST["kontoNr"];

$OK= $bank->registrerBetaling($kontoNr, $transaksjon);
echo json_encode($OK);
 