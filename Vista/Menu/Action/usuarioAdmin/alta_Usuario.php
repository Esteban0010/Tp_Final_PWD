<?php
include_once("../../../../configuracion.php");
$data = data_submitted();
$data['uspass'] = md5($data['uspass']); //encripta los datos

//echo "<script>console.log(" . json_encode($data) . ");</script>";

$respuesta = false;
if (isset($data['usnombre'])) {
    //echo "<script>console.log(" . json_encode($data) . ");</script>";
    $objAbmRol = new AbmRol();
    $objAbmUsuario = new AbmUsuario();    
    $objAbmUsuarioRol = new AbmUsuarioRol();

    $respuesta2 = $objAbmRol->alta($data);  // se carga el rol
    $respuesta = $objAbmUsuario->alta($data); // se carga el usuario

    // creacion de usuarioRol
    $colObjUsuario = $objAbmUsuario->darArray(null); //obtenie una col de objetos de usuarios
    $colObjRol = $objAbmRol->darArray(null);         //obtenie una col de objetos de roles

    $idUsuario = $colObjUsuario[count($colObjUsuario)-1]['idusuario']; //obtenie el id del objeto en especificio (ultimo)
    $idRol = $colObjRol[count($colObjRol)-1]['idrol'];             //obtenie el id del objeto en especificio (ultimo)

    $arrayIdUsuario = ["idusuario" => $idUsuario];    // se crea un array con la clave para obtener el objeto
    $arrayIdRol = ["idusuario" => $idRol];            // se crea un array con la clave para obtener el objeto

    $objUsuario = $objAbmUsuario->buscar($arrayIdUsuario); // obtiene el objeto usaurio
    $objRol = $objAbmRol->buscar($arrayIdRol);             // obtiene el objeto rol

    $nuevaColObjRol = ["idusuario" => $objUsuario[0], "idrol" => $objRol[0]]; // array con los dos objetos que necesita en el parametro

    $respuesta3 = $objAbmUsuarioRol->alta($nuevaColObjRol); // se agregan los datos del objeto usuarioRol en la BD

    if (!$respuesta && !$respuesta2 && !$respuesta3) {
        //verEstructura($data);
        $mensaje = " La accion  ALTA No pudo concretarse";
    }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
