<?php
include_once "../../../../configuracion.php";
//header('Content-Type: application/json; charset=utf-8');
$data = data_submitted();
//error_log('Datos recibidos: ' . print_r($data, true));
$respuesta = false;
if(isset($data['idmenu'])){
    $data['idmenu'] = (int) $data['idmenu'];
}
if(isset($data['idpadre']) && $data['idpadre'] != 'null'){
    $data['idpadre'] = (int) $data['idpadre'];
}

//echo "<script>console.log(" . json_encode('Esto es antes de modificar(), en edit_menu.php') . ");</script>";
//verEstructuraJson($data);

//echo "<script>console.log(" . json_encode($data) . ");</script>";

if (isset($data['idmenu'])) {
    $objC = new AbmMenu();
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
