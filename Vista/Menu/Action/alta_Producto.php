<?php
include_once("../../../configuracion.php");
$data = data_submitted();

$data['procantstock'] = (int) $data['procantstock'];
$data['valor'] = (int) $data['valor'];

//verEstructura($data);

//echo "<script>console.log(" . json_encode($data) . ");</script>";

$respuesta = false;
if (isset($data['pronombre'])) {
    //echo "<script>console.log(" . json_encode($data) . ");</script>";
    $objC = new AbmProducto();
    $respuesta = $objC->alta($data);
    if (!$respuesta) {
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
