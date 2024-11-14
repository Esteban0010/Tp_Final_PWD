<?php
include_once("../../../configuracion.php");

// Llamar a la función para procesar los datos
$datos = data_submitted();
//$datos['password'] = md5($datos['password']); //encripta los datos

//verEstructura($datos);

if ($datos['accion']=="login"){
    // Iniciar la sesión
    $session = new Session(); // Esto llama a session_start() en el constructor
    $resp = $session->iniciar($datos['usnombre'],$datos['uspassword']);    
    if($resp){          
        header("Location: ../paginaSegura.php");
        exit();   
    } else {
        $mensaje ="Error, usuario o password incorrecto";
        header("Location: ../login.php?msg=" . urlencode($mensaje));
        exit();
    }
}

if ($datos['accion']=="cerrar"){
    // Cerrar la sesión
    $objSession = new Session();
    $respuesta = $objSession->cerrar();
    if($respuesta) {
        $mensaje ="Session Cerrada.";
        header("Location: ../iniciar_sesion.php?msg=" . urlencode($mensaje));
        exit();    }
    
}
?>
