<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
//verEstructura($data);

$objAbmMenu = new AbmMenu();

$colMenu = $objAbmMenu->buscar($data);
//verEstructura($colUsuarios);
//verEstructura($colMenu);
//echo "<br><br><div>" . $colUsuarios[0]->getId() . "</div>";
$arreglo_salida =  array();

foreach ($colMenu as $elem) {

    $nuevoElem['idmenu'] = $elem->getIdmenu();
    $nuevoElem["menombre"] = $elem->getMenombre();
    $nuevoElem['medescripcion'] = $elem->getMedescripcion();
    $nuevoElem["idpadre"] = $elem->getObjMenu()->getIdmenu();
    $nuevoElem['medeshabilitado'] = $elem->getMedeshabilitado();

    array_push($arreglo_salida, $nuevoElem);
}

//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, null, 2);