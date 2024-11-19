<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
//verEstructura($data);
$objControl = new AbmUsuario();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem) {

    $nuevoElem['idusuario'] = $elem->getId();
    $nuevoElem["usnombre"] = $elem->getNombre();
    $nuevoElem["uspass"] = $elem->getPassword();
    $nuevoElem["usmail"] = $elem->getMail();
    $nuevoElem["usdeshabilitado"] = $elem->getDeshabilitado();     

    array_push($arreglo_salida, $nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, null, 2);
