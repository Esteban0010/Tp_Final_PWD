<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
if ($data['idpadre'] == 'null'){
    $data['idpadre'] = null;
} else {
    $data['idpadre'] = (int) $data['idpadre'];
}


//hasta aca funciona
//$data['idpadre'] = (int) $data['idpadre'];
//verEstructuraJson($data);

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
