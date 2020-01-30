<?php
session_start();
include_once '../BLL/bankLogikk.php';
header('Content-Type: application/json');
if(!isset($_SESSION["loggetInn"]))
{
    echo json_encode("Feil innlogging");
    die();
}
if(isset($_GET["test"]))
{
    $bank=new Bank(new BankDBStub()); // ved å legge på en test til slutt på tx!
}
else
{
    $bank = new Bank();
}
// etter dette er innlogging godkjent og riktig bank-klasse innstansiert.
