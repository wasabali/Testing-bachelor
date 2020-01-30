<?php
include_once 'apiBankHeader.php';

$TxID = $_GET["TxID"];
$OK= $bank->utforBetaling($TxID);

// returner oppdatert utestående betalinger for visning.

$personnummer = $_SESSION["loggetInn"];
$betalinger = $bank->hentBetalinger($personnummer);
echo json_encode($betalinger);
