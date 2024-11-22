<?php
include_once "../../../../configuracion.php";
$data = data_submitted();

if(isset($data['idmenu'])){
    $data['idmenu'] = (int) $data['idmenu'];
}
// cambia el ate('Y-m-d H:i:s') por una fecha null (habilitada)
$data['medeshabilitado'] = '0000-00-00 00:00:00';

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
