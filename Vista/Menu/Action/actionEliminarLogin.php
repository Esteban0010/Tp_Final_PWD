<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
//verEstructura($datos);

if(isset($datos)){
    if($datos['accion'] == 'eliminar'){
        $objAbmUsuario = new AbmUsuario();
        $objUsuario = $objAbmUsuario->darArray($datos);
        $objUsuario[0]['usdeshabilitado'] = date('Y-m-d H:i:s');        
        if($objAbmUsuario->modificacion($objUsuario[0])){
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