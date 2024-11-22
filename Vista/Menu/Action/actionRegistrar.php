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
 //esta es una forma con el javascript:
    //echo ("<script>location.href = '../login.php';</script>");

    // Otra opción sería usar el método header de PHP para redirigir, 
    // que es más seguro y confiable cuando se hace al inicio del procesamiento del script:
    //header("Location: ../login.php");

    // este es fran-----------------------------------------------------

    // header("Location: ../registrarse.php?msg=" . urlencode($mensajeRegistro));
/*
    Entre el script y el header... Cual es el mejor?

    Entre header y el uso de echo con <script>, generalmente es preferible usar header para redirecciones en PHP, y aquí están las razones principales:

        1) Compatibilidad y seguridad: header("Location: ...") es un método nativo de PHP, lo que lo hace más seguro y compatible en todos los navegadores, ya que PHP gestiona la redirección antes de enviar cualquier HTML al cliente. Con JavaScript (<script>), estás confiando en que el navegador ejecute el script, lo cual puede fallar si el usuario tiene JavaScript deshabilitado.

        2) Rendimiento: header es más directo y eficiente. Evita el uso adicional de HTML y JavaScript, logrando el redireccionamiento de manera inmediata a nivel del servidor, sin depender de los recursos del navegador.

        3) Evita problemas de salida accidental: header solo funciona si no ha habido salida previa. Así, te permite detectar si accidentalmente has enviado datos al navegador (lo que bloquearía las redirecciones), mientras que <script> puede enmascarar este tipo de errores.

        4) Experiencia del usuario: Las redirecciones con header ocurren inmediatamente. El <script> en cambio puede ser menos intuitivo si el navegador tarda en ejecutar el código.

    Resumen:
    Utiliza header("Location: ...") siempre que sea posible, especialmente en redirecciones importantes, ya que es más confiable y seguro para gestionar redirecciones a nivel de servidor.


    =========================================================================================================================


    y al header como le puedo agregar el ?msg=.... como este: 
                    echo("<script>location.href = '../login.php?msg=$mensaje';</script>");

    Para pasar parámetros en la URL con header, puedes concatenar la variable de la misma forma que con el <script>. Aquí tienes cómo hacerlo:

                header("Location: ../login.php?msg=" . urlencode($mensaje));
                exit();

    Explicación:
    urlencode($mensaje): Esto convierte cualquier carácter especial en una forma segura para la URL, evitando problemas si $mensaje contiene espacios u otros caracteres que no sean compatibles en la URL.
    exit();: Asegúrate de usar exit(); después de header para detener la ejecución del script después de la redirección.
    Con esto, tu redirección debería funcionar correctamente con el mensaje incluido en la URL.
*/
