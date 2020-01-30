<?php
session_start();
unset($_SESSION["loggetInn"]);
header("Location:../Index.php");
