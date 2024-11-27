<?php
include_once("../../../configuracion.php");


// Llamar a la función para procesar los datos}
$datos = data_submitted();
if (isset($datos['uspass'])) {
    $datos['uspass'] = md5($datos['uspass']); //encripta los datos
}

//verEstructura($datos);

if ($datos['accion'] == "login") {

    $session = new Session();
    $resp = $session->iniciar($datos['usnombre'], $datos['uspass']);

    if ($resp) {
        $response = [
            'respuesta' => true,
            'redirect' => 'menu.php'
        ];
    } else {
        $response = [
            'respuesta' => false,
            'redirect' => 'iniciar_sesion.php'
        ];
    }
} elseif ($datos['accion'] == "cerrar") {
    $objSession = new Session();
    $objSession->cerrar();
    // $response['respuesta'] =  //true 
    //     $response['redirect'] = 'iniciar_sesion.php';
    $response = [
        'respuesta' => 'cerrar',
        'redirect' => 'iniciar_sesion.php'
    ];
}

// Limpia el buffer de salida y envía la respuesta JSON
ob_clean();
echo json_encode($response);
exit;
