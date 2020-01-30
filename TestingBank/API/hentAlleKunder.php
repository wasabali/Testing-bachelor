<?php
include_once 'apiAdminHeader.php';

$alleKunder= $admin->hentAlleKunder();
echo json_encode($alleKunder);
 