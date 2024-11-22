<?php
include_once "../../../../configuracion.php";
$data = data_submitted();

if(isset($data['idmenu'])){
    $data['idmenu'] = (int) $data['idmenu'];
}
// cambia el 0000-00-00 00:00:00 por una fecha
$data['medeshabilitado'] = date('Y-m-d H:i:s');

if (isset($data['idmenu'])) {
    //echo "<script>console.log(" . json_encode('adentro del abm') . ");</script>"; 
    $objC = new AbmMenu();
    $respuesta = $objC->modificacion($data);
    if (!$respuesta) {
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
