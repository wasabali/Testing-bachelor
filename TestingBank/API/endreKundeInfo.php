<?php
include_once 'apiBankHeader.php';
$kunde = new kunde();
$kunde->personnummer = $_SESSION["loggetInn"];
$kunde->fornavn      = $_POST["fornavn"];
$kunde->etternavn    = $_POST["etternavn"];
$kunde->adresse      = $_POST["adresse"];
$kunde->postnr       = $_POST["postnr"];
$kunde->poststed     = $_POST["poststed"];
$kunde->telefonnr    = $_POST["telefonnr"];
$kunde->passord      = $_POST["passord"];

$OK= $bank->endreKundeInfo($kunde);
echo json_encode($OK);
 