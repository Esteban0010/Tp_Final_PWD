<?php
include_once("../../../configuracion.php");

$session = new Session();

echo json_encode([
    'logged_in' => $session->activa()
]);