<?php
include_once 'apiBankHeader.php';

$personnummer = $_SESSION["loggetInn"];
$konti= $bank->hentkonti($personnummer);
echo json_encode($konti);
