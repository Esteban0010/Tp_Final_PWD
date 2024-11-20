<?php
include_once("../../../../configuracion.php");

function esMd5($valor) {
    // Verifica que el valor tenga 32 caracteres y sean caracteres hexadecimales
    return preg_match('/^[a-f0-9]{32}$/i', $valor) === 1;
}

$data = data_submitted();

if(!esMd5($data['uspass'])){
    $data['uspass'] = md5($data['uspass']);
}

$data['idusuario'] = (int) $data['idusuario'];

//verEstructuraJson($data);

//echo "<script>console.log(" . json_encode($data) . ");</script>";
$respuesta = false;
//$respuesta2 = false;
if (isset($data['idusuario'])) {
    //verEstructuraJson($data);
    $objAbmUsuario = new AbmUsuario();
    //$objAbmRol = new AbmRol();

    $respuesta = $objAbmUsuario->modificacion($data);
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
