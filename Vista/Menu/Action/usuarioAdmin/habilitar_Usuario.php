<?php
include_once "../../../../configuracion.php";
$data = data_submitted();

if(isset($data['idusuario'])){
    $data['idusuario'] = (int) $data['idusuario'];
}
// cambia el ate('Y-m-d H:i:s') por una fecha null (habilitada)
$data['usdeshabilitado'] = '0000-00-00 00:00:00';

if (isset($data['idusuario'])) {
    //echo "<script>console.log(" . json_encode('adentro del abm') . ");</script>"; 
    $objC = new AbmUsuario();
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
