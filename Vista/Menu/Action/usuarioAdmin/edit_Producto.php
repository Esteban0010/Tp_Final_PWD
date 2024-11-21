<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$respuesta = false;
$data['idproducto'] = (int) $data['idproducto'];
$data['procantstock'] = (int) $data['procantstock'];
$data['valor'] = (int) $data['valor'];

//verEstructuraJson($data);
//echo "<script>console.log(" . json_encode($data) . ");</script>";

if (isset($data['idproducto'])) {
    $objC = new AbmProducto();
    $respuesta = $objC->modificacion($data);

    if (!$respuesta) {

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
    } else $respuesta = true;
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $sms_error;
}
echo json_encode($retorno);
