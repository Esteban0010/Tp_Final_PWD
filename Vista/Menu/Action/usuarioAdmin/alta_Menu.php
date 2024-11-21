<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
//verEstructura($data);
$respuesta = false;
if (isset($data['menombre'])) {
    $objC = new AbmMenu();
    $respuesta = $objC->alta($data);
    // $respuesta restorna true
    if (!$respuesta) {
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
