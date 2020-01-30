<?php
session_start();
include_once '../BLL/adminLogikk.php';
header('Content-Type: application/json');
if(isset($_SESSION["loggetInn"]))
{
    if($_SESSION["loggetInn"]!="Admin")
    {
        // ikke logget inn
        echo json_encode("Feil innlogging");
        die();
    }
}
else
{
    // ikke logget inn
    echo json_encode("Feil innlogging");
    die();
}
if(isset($_GET["test"]))
{
    $admin = new Admin(new AdminDBStub()); // ved å legge på en test til slutt på tx!
}
else
{
    $admin = new Admin();
}
// etter dette er innlogging godkjent og riktig admin-klasse innstansiert.
