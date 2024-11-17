<?php
include_once("../../../configuracion.php");
$data = data_submitted();
//verEstructura($data);
$objControl = new AbmProducto();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem) {

    $nuevoElem['idproducto'] = $elem->getIdProducto();
    $nuevoElem["pronombre"] = $elem->getProNombre();
    $nuevoElem["prodetalle"] = $elem->getProDetalle();
    $nuevoElem["procantstock"] = $elem->getProCantStock();
    $nuevoElem["valor"] = $elem->getValor();    

    array_push($arreglo_salida, $nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, null, 2);
