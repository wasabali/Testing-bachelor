<?php
include_once 'apiBankHeader.php';

$personnummer = $_SESSION["loggetInn"];
$kunde= $bank->hentKundeInfo($personnummer);
echo json_encode($kunde);
