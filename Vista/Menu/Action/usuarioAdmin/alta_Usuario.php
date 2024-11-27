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

    $idUsuario = $colObjUsuario[count($colObjUsuario) - 1]['idusuario']; //obtenie el id del objeto en especificio (ultimo)
    $idRol = $colObjRol[count($colObjRol) - 1]['idrol'];             //obtenie el id del objeto en especificio (ultimo)

    $arrayIdUsuario = ["idusuario" => $idUsuario];    // se crea un array con la clave para obtener el objeto
    $arrayIdRol = ["idrol" => $idRol];            // se crea un array con la clave para obtener el objeto

    $objUsuario = $objAbmUsuario->buscar($arrayIdUsuario); // obtiene el objeto usaurio
    $objRol = $objAbmRol->buscar($arrayIdRol);             // obtiene el objeto rol

    $nuevaColObjRol = ["idusuario" => $objUsuario[0], "idrol" => $objRol[0]]; // array con los dos objetos que necesita en el parametro

    $respuesta3 = $objAbmUsuarioRol->alta($nuevaColObjRol); // se agregan los datos del objeto usuarioRol en la BD

    /* ========== parte de menu ===========*/
    $objAbmMenuHogar = new AbmMenu();
    $objAbmMenuProductos = new AbmMenu();
    $objAbmMenuMiPerfil = new AbmMenu();
    $objAbmMenuCarrito = new AbmMenu();
    $objAbmMenuCerrarSesion = new AbmMenu();

    $arrayHogar = ["idmenu" => null, "menombre" => "Hogar", "medescripcion" => "menu.php", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];
    $arrayProductos = ["idmenu" => null, "menombre" => "Productos", "medescripcion" => "productos.php", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];
    $arrayMiPerfil = ["idmenu" => null, "menombre" => "Mi Perfil", "medescripcion" => "perfilUser.php", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];
    $arrayCarrito = ["idmenu" => null, "menombre" => "Carrito", "medescripcion" => "carrito.php", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];
    $arrayMenuCerrarSesion = ["idmenu" => null, "menombre" => "Cerrar Sesion", "medescripcion" => "Action/actionVerificarLogin.php?accion=cerrar", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];

    $respuestaHogar = $objAbmMenuHogar->alta($arrayHogar);
    $respuestaProductos = $objAbmMenuProductos->alta($arrayProductos);
    $respuestaMiPerfil = $objAbmMenuMiPerfil->alta($arrayMiPerfil);
    $respuestaCarrito = $objAbmMenuCarrito->alta($arrayCarrito);
    $respuestaCerrarSesion = $objAbmMenuCerrarSesion->alta($arrayMenuCerrarSesion);

    /* ========== parte de menurol ===========*/
    $objAbmMenuRolHogar = new AbmMenuRol();
    $colMenuHogar = $objAbmMenuHogar->buscar($arrayHogar);
    $contador1 = count($colMenuHogar) - 1;
    $colMenuHogar[$contador1]; // obtiene el ultimo objeto del menu 
    $respMeRolHogar = $objAbmMenuRolHogar->alta(["idmenu" => $colMenuHogar[$contador1], "idrol" => $objRol[0]]);

    //echo "<script>console.log(" . json_encode('objeto rol') . ");</script>";
    //verEstructuraJson($objRol[0]);
    //echo "<script>console.log(" . json_encode('objeto usuario') . ");</script>";
    //verEstructuraJson($colMenuHogar[$contador1]);

    $objAbmMenuRolProdcutos = new AbmMenuRol();
    $colMenuProductos = $objAbmMenuProductos->buscar($arrayProductos);
    $contador2 = count($colMenuProductos) - 1;
    $colMenuProductos[$contador2]; // obtiene el ultimo objeto del menu 
    $respMeRolProducto = $objAbmMenuRolProdcutos->alta(["idmenu" => $colMenuProductos[$contador2], "idrol" => $objRol[0]]);


    $objAbmMenuRolMiPerfil = new AbmMenuRol();
    $colMenuMiPerfil = $objAbmMenuMiPerfil->buscar($arrayMiPerfil);
    $contador3 = count($colMenuMiPerfil) - 1;
    $colMenuMiPerfil[$contador3]; // obtiene el ultimo objeto del menu
    $respMeRolMiperfil = $objAbmMenuRolMiPerfil->alta(["idmenu" => $colMenuMiPerfil[$contador3], "idrol" => $objRol[0]]);


    $objAbmMenuRolCarrito = new AbmMenuRol();
    $colMenuCarrito = $objAbmMenuCarrito->buscar($arrayCarrito);
    $contador4 = count($colMenuCarrito) - 1;
    $colMenuCarrito[$contador4]; // obtiene el ultimo objeto del menu 
    $respMeRolCarrito = $objAbmMenuRolCarrito->alta(["idmenu" => $colMenuCarrito[$contador4], "idrol" => $objRol[0]]);


    $objAbmMenuRolCerrarSesion = new AbmMenuRol();
    $colMenuCerrarSesion = $objAbmMenuCerrarSesion->buscar($arrayMenuCerrarSesion);
    $contador5 = count($colMenuCerrarSesion) - 1;
    $colMenuCerrarSesion[$contador5]; // obtiene el ultimo objeto del menu 
    $respMeRolCerrarSesion = $objAbmMenuRolCerrarSesion->alta(["idmenu" => $colMenuCerrarSesion[$contador5], "idrol" => $objRol[0]]);

    if ($data['rodescripcion'] == 'deposito') {
        /* ========== parte de menu de deposito ===========*/
        $objAbmMenuDeposito = new AbmMenu();
        $arrayMenuDeposito = ["idmenu" => null, "menombre" => "Gestion de Compras", "medescripcion" => "gestionarCompra3.php", "idpadre" => null, "medeshabilitado" => "0000-00-00 00:00:00"];
        $respuestaDeposito = $objAbmMenuDeposito->alta($arrayMenuDeposito);

        /* ========== parte de menurol de deposito ===========*/
        $objAbmMenuRolDeposito = new AbmMenuRol();
        $colMenuDeposito = $objAbmMenuDeposito->buscar($arrayMenuDeposito);
        $contador6 = count($colMenuDeposito) - 1;
        $colMenuDeposito[$contador6]; // obtiene el ultimo objeto del menu 
        $respMeRolDeposito = $objAbmMenuRolDeposito->alta(["idmenu" => $colMenuDeposito[$contador6], "idrol" => $objRol[0]]);
    }

    if (!$respuesta && !$respuesta2 && !$respuesta3) { // verifica usuairo, ro y menurol si se crearon y guardo los datos

        // verifica los menus si se crearon y guardo los datos
        if (!$respuestaHogar && !$respuestaProductos && !$respuestaMiPerfil && !$respuestaCarrito && !$respuestaCerrarSesion) {

            // verifica los menurol si se crearon y guardo los datos
            if (!$respMeRolHogar && !$respMeRolProducto && !$respMeRolMiperfil && !$respMeRolCarrito && !$respMeRolCerrarSesion) {

                if ($data['rodescripcion'] == 'deposito') {

                    if (!$respMeRolDeposito && !$respuestaDeposito) { // validacion completa de rol deposito
                        //verEstructura($data);
                        $mensaje = " La accion  ALTA No pudo concretarse";
                    }
                } else { // validacion completa de rol cliente
                    //verEstructura($data);
                    $mensaje = " La accion  ALTA No pudo concretarse";
                }
            }
        }
    }
} //fin del if padre

$retorno['respuesta'] = $respuesta;

if (isset($mensaje)) {

    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
