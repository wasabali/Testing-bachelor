<?php
session_start();
header('Content-Type: application/json');

// hardkoding av innlogging til Admin!

$bruker = $_GET["bruker"];
$passord =$_GET["passord"];

if($bruker==="Admin" && $passord==="Admin")
{
    $_SESSION["loggetInn"]="Admin";
    echo json_encode("Admin");
}
else
{
    unset($_SESSION["loggetInn"]);
    echo json_encode("Feil i innlogging");
}
