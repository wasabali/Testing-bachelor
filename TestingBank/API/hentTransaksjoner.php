<?php
include_once 'apiBankHeader.php';
// henter alle transaksjoner mellom to dato´er for en konto der avventer !=0
$kontoNr = $_GET["kontoNr"];
$fraDato =$_GET["fraDato"];
$tilDato =$_GET["tilDato"];

$konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
echo json_encode($konto);
 
