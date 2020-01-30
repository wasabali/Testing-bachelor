<?php
include_once 'apiBankHeader.php';

$personnummer = $_SESSION["loggetInn"];
$saldi= $bank->hentSaldi($personnummer);
echo json_encode($saldi);
