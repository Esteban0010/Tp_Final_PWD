<?php
include_once("../../../configuracion.php");


// Llamar a la función para procesar los datos}
$datos = data_submitted();


if ($datos['accion'] == "login") {

    $session = new Session();
    $resp = $session->iniciar($datos['usnombre'], $datos['uspass']);

    if ($resp) {
        $response['respuesta'] = 1;
        $response['redirect'] = 'paginaSegura.php';
    } else {
        $response['respuesta'] = 2;
    }
} elseif ($datos['accion'] == "cerrar") {
    $objSession = new Session();
    $objSession->cerrar(); //true 
    $response['respuesta'] = 3;
    $response['redirect'] = 'iniciar_sesion.php';
}

ob_clean();
echo json_encode($response);
exit;


// if ($datos['accion'] == "login") {

//     $session = new Session();
//     $resp = $session->iniciar($datos['usnombre'], $datos['uspass']);

//     if ($resp) {
//         $response['respuesta'] = true;
//         $response['redirect'] = 'paginaSegura.php';
//     } else {
//         $response['respuesta'] = false;
//     }
// } elseif ($datos['accion'] == "cerrar") {
//     $objSession = new Session();
//     $response['respuesta'] = 'no pongamos nada '; //true 
//     $response['redirect'] = 'iniciar_sesion.php';
//     $objSession->cerrar();
// }

// Limpia el buffer de salida y envía la respuesta JSON
