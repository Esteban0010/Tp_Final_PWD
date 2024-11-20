<?php
include_once("../../../../configuracion.php");

$data = data_submitted();
//verEstructuraJson($data);

//echo "<script>console.log(" . json_encode($data) . ");</script>";
$respuesta = false;
//$respuesta2 = false;
if (isset($data['rodescripcion'])) {
    //verEstructuraJson($data);
    $objAbmRol = new AbmRol();
    //$objAbmRol = new AbmRol();

    $respuesta = $objAbmRol->modificacion($data);
    //$respuesta2 = $objAbmRol->modificacion($data);
    //echo "<script>console.log(" . json_encode($respuesta2) . ");</script>";

    if (!$respuesta) {
        $sms_error = " La accion  MODIFICACION No pudo concretarse";
    } else {
        $respuesta = true;
    } 
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $sms_error;
}
echo json_encode($retorno);
