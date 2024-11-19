<?php
include_once("../../../../configuracion.php");
$data = data_submitted();

//echo "<script>console.log(" . json_encode($data) . ");</script>";

$respuesta = false;
if (isset($data['usnombre'])) {
    //echo "<script>console.log(" . json_encode($data) . ");</script>";
    $objC = new AbmUsuario();
    $respuesta = $objC->alta($data);
    if (!$respuesta) {
        //verEstructura($data);
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
