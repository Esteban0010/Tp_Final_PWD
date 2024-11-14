<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$datos['uspass'] = md5($datos['uspass']); //encripta los datos
//verEstructura($datos);

if(isset($datos)){
    if($datos['accion'] == 'editar'){
        $objAbmUsuario = new AbmUsuario();
        if($objAbmUsuario->modificacion($datos)){
            header("Location: ../listarUsuario.php");
            exit();
        } else {
            header("Location: ../editarUsuario.php");
            exit();
        }    
    } else {
        header("Location: ../editarUsuario.php");
        exit();
    }
} else {
    header("Location: ../editarUsuario.php");
    exit();
}
?>