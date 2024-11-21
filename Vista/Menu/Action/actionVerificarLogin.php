<?php
include_once("../../../configuracion.php");
// Llamar a la función para procesar los datos
$datos = data_submitted();
verEstructura($datos);

if ($datos['accion'] == "login") {
    // Iniciar la sesión
    $session = new Session(); // Esto llama a session_start() en el constructor
    // $datos['uspass'] = md5($datos['uspass']); //encripta los datos

    $resp = $session->iniciar($datos['usnombre'], $datos['uspass']);

    if ($resp) {

        header("Location: ../paginaSegura.php");
    } else {
        $mensaje = "Error, usuario o password incorrecto";
        header("Location: ../iniciar_sesion.php?msg=" . urlencode($mensaje));
    }
}

if ($datos['accion'] == "cerrar") {
    // Cerrar la sesión
    $objSession = new Session();
    $respuesta = $objSession->cerrar();
    if ($respuesta) {
        $mensaje = "Session Cerrada.";
        header("Location: ../iniciar_sesion.php?msg=" . urlencode($mensaje));
    }
}
