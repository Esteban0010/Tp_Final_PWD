<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
//verEstructura($data);

//$objAbmUsuarioRol = new AbmUsuarioRol();
//$colObjAbmUsuarioRol = $objAbmUsuarioRol->darArrayCompleto(null);

$objAbmRol= new AbmRol();
//$objAbmUsuario = new AbmUsuario();

$colRols = $objAbmRol->buscar($data);
//$colUsuarios = $objAbmUsuario->buscar($data);
//verEstructura($colUsuarios);
//verEstructura($colRols);
//echo "<br><br><div>" . $colUsuarios[0]->getId() . "</div>";
$arreglo_salida =  array();
//foreach ($list as $elem)
//for ($i = 0; $i < count($colUsuarios); $i++) 
foreach ($colRols as $elem){

    $nuevoElem['idrol'] = $elem->getId();
    $nuevoElem["rodescripcion"] = $elem->getDescripcion();

    array_push($arreglo_salida, $nuevoElem);
}

//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, null, 2);

//echo json_encode($colObjAbmUsuarioRol, null, 2);