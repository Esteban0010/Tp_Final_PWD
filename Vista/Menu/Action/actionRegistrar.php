<?php
include_once("../../../configuracion.php");
include_once "../../Estructura/Header.php";
$resp = false;
$datos = data_submitted();
//verEstructura($datos);

if (isset($datos)) {
    // creacion de instancias de onjetos
    $objAbmRol = new AbmRol();
    $objAbmUsuario = new AbmUsuario();
    $objAbmUsuarioRol = new AbmUsuarioRol();

    $datos['uspass'] = md5($datos['uspass']);
    $res1 = $objAbmRol->alta($datos);     // carga al objeto y sube los daots a la BD
    $res2 = $objAbmUsuario->alta($datos); // carga al objeto y sube los daots a la BD
    if ($res2 <> true) {
        $mensajeRegistro = [
            'respuesta' => false,
            'redirect' => 'registrarse.php'
        ];
    }
    if ($res1 && $res2) {
        $colObjUsuario = $objAbmUsuario->darArray(null); //obtenie una col de objetos de usuarios
        $colObjRol = $objAbmRol->darArray(null);         //obtenie una col de objetos de roles

        //verEstructura($colObjUsuario);

        $idUsuario = $colObjUsuario[count($colObjUsuario) - 1]['idusuario']; //obtenie el id del objeto en especificio (ultimo)
        $idRol = $colObjRol[count($colObjRol) - 1]['idusuario'];             //obtenie el id del objeto en especificio (ultimo)

        $arrayIdUsuario = ["idusuario" => $idUsuario];    // se crea un array con la clave para obtener el objeto
        $arrayIdRol = ["idusuario" => $idRol];            // se crea un array con la clave para obtener el objeto

        $objUsuario = $objAbmUsuario->buscar($arrayIdUsuario); // obtiene el objeto usaurio
        $objRol = $objAbmRol->buscar($arrayIdRol);             // obtiene el objeto rol

        $nuevaColObjRol = ["idusuario" => $objUsuario[0], "idrol" => $objRol[0]]; // array con los dos objetos que necesita en el parametro

        $res3 = $objAbmUsuarioRol->alta($nuevaColObjRol); // se agregan los datos del objeto usuarioRol en la BD

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

        //echo "<script>console.log(" . json_encode($contador1) . ");</script>";
        //verEstructuraJson($colMenuHogar[$contador1]);
        //verEstructuraJson($objRol[0]);


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


        if ($res1 && $res2 && $res3) { // dar mensaje para el h1 de titulo
            $mensajeRegistro = [
                'respuesta' => true,
                'redirect' => 'iniciar_sesion.php'
            ];
        } else {
            $mensajeRegistro = [
                'respuesta' => false,
                'redirect' => 'registrarse.php'
            ];
        }
    } else {
        $mensajeRegistro = [
            'respuesta' => false,
            'redirect' => 'registrarse.php'
        ];
    }
    ob_clean();
    echo json_encode($mensajeRegistro);
    exit();
}
