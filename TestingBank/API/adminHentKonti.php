<?php
include_once 'apiAdminHeader.php';

$konti= $admin->hentAlleKonti();
echo json_encode($konti);
 