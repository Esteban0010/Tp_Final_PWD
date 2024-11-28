<?php
include_once "../../../../configuracion.php";
$data = data_submitted();

// Crear una instancia de AbmMenu o la clase que maneja los submenús
$objControl = new AbmMenu();

// Buscar los submenús (esto puede ser adaptado dependiendo de tu lógica de base de datos)
$list = $objControl->buscar($data); 

$arreglo_salida = array();

// Recorrer los submenús y formatearlos para el combobox
foreach ($list as $elem) {
    $nuevoElem = array();
    $nuevoElem['id'] = $elem->getIdMenu(); // El valor que se guarda en el combobox
    $nuevoElem['text'] = $elem->getIdMenu() . ": " . $elem->getMedescripcion();  // El texto que se muestra en el combobox

    array_push($arreglo_salida, $nuevoElem);
}

//verEstructura($list);
//verEstructura($arreglo_salida);
// Devuelve los submenús en formato JSON
echo json_encode($arreglo_salida, JSON_UNESCAPED_UNICODE);
?>
