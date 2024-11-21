<?php
include_once "../../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
$data['idmenu'] = (int) $data['idmenu'];
if(isset($data['idpadre'])){
    $data['idpadre'] = (int) $data['idpadre'];
}
// Para depuración, envía el contenido de $data como respuesta JSON
//echo json_encode($data);
//exit; // Detiene la ejecución después de enviar los datos
//echo "<script>console.log(" . json_encode('Esto es antes de modificar(), en edit_menu.php') . ");</script>";
verEstructuraJson($data);

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
