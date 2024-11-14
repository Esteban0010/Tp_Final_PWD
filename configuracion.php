<?php
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");

// CONFIGURACION APP
$PROYECTO = 'Tp_Final_PWD';

// Define ROOT como una variable global
$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

// Incluye las funciones después de definir ROOT
include_once($GLOBALS['ROOT'] . 'Util/funciones.php');

// Variable que define la página de autenticación del proyecto
$INICIO = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/login/login.php";

// Variable que define la página principal del proyecto (menú principal)
$PRINCIPAL = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/principal.php";

/*
    Con este cambio, $GLOBALS['ROOT'] estará disponible en todo el script, 
    y en otros archivos PHP que incluyan configuracion.php, tendrás acceso 
    a la ruta base del proyecto. Esto permite que no tengas que redefinir ROOT 
    en otros archivos y lo trates como una variable global.
*/
?>