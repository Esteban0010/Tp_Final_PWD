<?php 
include_once("../../../configuracion.php");
$datos = data_submitted();//Recibe idcompraitem 
//verEstructura($datos);

if(isset($datos['idcompra'])){
    $objCompraItem = new AbmCompraItem();
    $respuesta= $objCompraItem->baja($datos);
    if (!$respuesta) {
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);