<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
$respuesta = false;

$data['idusuario'] = (int) $data['idusuario'];


//echo "<script>console.log(" . json_encode($data) . ");</script>";

if (isset($data['idusuario'])) {
    //verEstructuraJson($data);
    $objC = new AbmUsuario();
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
