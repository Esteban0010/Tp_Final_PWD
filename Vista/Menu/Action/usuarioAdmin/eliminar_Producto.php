<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$data['idproducto'] = (int) $data['idproducto'];

// echo "<script>console.log(" . json_encode('hola id, eliminar_menu.php') . ");</script>";
// echo "<script>console.log(" . json_encode($data) . ");</script>";

if (isset($data['idproducto'])) {
    $objC = new AbmProducto();
    $respuesta = $objC->baja($data);
    if (!$respuesta) {
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
