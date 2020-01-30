<?php
include_once 'apiBankHeader.php';

// henter alle transaksjoner for personen som avventer betalinger avventer == 1
// $bank objektet i BLL er allerede innsansiert i ApiHeader.php

$personnummer = $_SESSION["loggetInn"];
$betalinger= $bank->hentBetalinger($personnummer);
echo json_encode($betalinger);
 