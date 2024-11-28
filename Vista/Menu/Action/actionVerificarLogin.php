<?php
include_once("../../../configuracion.php");


// Llamar a la función para procesar los datos}
$datos = data_submitted();
if (isset($datos['uspass'])) {
    $datos['uspass'] = md5($datos['uspass']); //encripta los datos
}

verEstructura($datos);

if ($datos['accion'] == "login") {

    $session = new Session();
    $resp = $session->iniciar($datos['usnombre'], $datos['uspass']);

    if ($resp) {
        $response = [
            'respuesta' => true,
            'redirect' => 'menu.php',
            'cerrar' => false
        ];
    } else {
        $response = [
            'respuesta' => false,
            'redirect' => 'iniciar_sesion.php',
            'cerrar' => false
        ];
    }
}
if ($datos['accion'] == "cerrar") {
    $objSession = new Session();
    $bool =  $objSession->cerrar();
    if ($bool) {
        header("Location: ../iniciar_sesion.php");
    }
}
// Limpia el buffer de salida y envía la respuesta JSON
ob_clean();
echo json_encode($response);
exit;
