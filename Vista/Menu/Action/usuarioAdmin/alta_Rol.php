<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
//echo "<script>console.log(" . json_encode($data) . ");</script>";

$respuesta = false;
if (isset($data['rodescripcion'])) {
    //echo "<script>console.log(" . json_encode($data) . ");</script>";
    $objAbmRol = new AbmRol();
    $respuesta = $objAbmRol->alta($data);  // se carga el rol

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
