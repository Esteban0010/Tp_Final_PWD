<?php
include_once("../../configuracion.php");
$datos = data_submitted();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerce seguro</title>

    <!-- Letras Poppins -->
    <link rel="stylesheet" href="../Asets/css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">


    <!-- css bootstrap 5 -->
    <link href="../Asets/librerias/bootstrap-5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- css bootstrap 5 -->
    <link href="../Asets/librerias/bootstrap-5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- js bootstrap 5 -->
    <script src="../Asets/librerias/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jquery-easyui -->
    <link rel="stylesheet" type="text/css" href="../Asets/librerias/jquery-easyui-1.11.0/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../Asets/librerias/jquery-easyui-1.11.0/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../Asets/librerias/jquery-easyui-1.11.0/themes/color.css">
    <link rel="stylesheet" type="text/css" href="../Asets/librerias/jquery-easyui-1.11.0/demo/demo.css">
    <script type="text/javascript" src="../Asets/librerias/jquery-easyui-1.11.0/jquery.min.js"></script>
    <!-- jquery-3.6.0 (debe estar antes que jquery-easyui-1.11.0) -->
    <script src="../Asets/librerias/jquery-3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../Asets/librerias/jquery-easyui-1.11.0/jquery.easyui.min.js"></script>

</head>

<body>

    <?php
    $colObjMenus = new AbmMenuRol();
    $objTrans = new Session();
    // $objTrans->cerrar();
    $resp = $objTrans->validar();
    if ($resp) {
        // echo "hola";
        $objUsuario = $objTrans->getUsuario();
        $objRol = $objTrans->getRol();
        //verEstructura($objUsuario);
        //verEstructura($objRol);
        $colMenurol = $colObjMenus->buscar(['idrol' => $objRol->getId()]); // col de todos los menu que tiene el usuario
        //verEstructura($colMenurol);
        $descripcionRol = $objRol->getDescripcion();

        // hogar
        $objAbmHogar = new AbmMenu;
        $colMenusHogar = $objAbmHogar->buscar(['idpadre' => $colMenurol[0]->getObjMenu()->getIdmenu()]); // busco el primer menu "Hogar" si tiene hijas con su id
        //verEstructura($colMenusHogar);  
        //echo count($colMenusHogar);

        //prodcutos
        $objAbmProductos = new AbmMenu;
        $colMenusProductos = $objAbmProductos->buscar(['idpadre' => $colMenurol[1]->getObjMenu()->getIdmenu()]); // busco el primer menu "productos" si tiene hijas con su id

        //carrito
        $objAbmCarrito = new AbmMenu;
        $colMenusCarrito = $objAbmCarrito->buscar(['idpadre' => $colMenurol[3]->getObjMenu()->getIdmenu()]); // busco el primer menu "carrito" si tiene hijas con su id
        //verEstructura($colMenusCarrito);

        //mi perfil
        $objAbmMiPerfil = new AbmMenu;
        $colMenusMiPerfil = $objAbmMiPerfil->buscar(['idpadre' => $colMenurol[2]->getObjMenu()->getIdmenu()]); // busco el primer menu "Mi perfil" si tiene hijas con su id

        //cerrar session
        $objAbmCerrar = new AbmMenu;
        $colMenusCerrar = $objAbmCerrar->buscar(['idpadre' => $colMenurol[4]->getObjMenu()->getIdmenu()]); // busco el primer menu "cerrar sesion" si tiene hijas con su id     

    }

    ?>

    <header>
        <nav class="navbar navbar-expand-lg bg-black border-bottom py-3" style="width: 100%;">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <?php
                    if (isset($descripcionRol)) {

                        // Enlaces atribuidos a cada rol
                        if ($descripcionRol == 'cliente') {

                    ?> <!-- Barra de búsqueda -->
                            <div class="flex-grow-1 px-3">
                                <input type="search" class="form-control border-0 border-bottom rounded-0"
                                    placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                            </div>

                            <?php
                            // hogar
                            if ($colMenusHogar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Hogar</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusHogar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Hogar   
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[0]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Productos
                            if ($colMenusProductos != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Productos</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusProductos as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Productos
                                if ($colMenurol[1]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[1]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // carrito
                            //if()
                            if ($colMenusCarrito != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Carrito</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCarrito as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Carrito
                                if ($colMenurol[3]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[3]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // mi perfil =============================================
                            if ($colMenusMiPerfil != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusMiPerfil as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Mi perfil
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[2]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // cerrar sesion
                            if ($colMenusCerrar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Cerrar Sesion</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCerrar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Cerrar sesión
                                if ($colMenurol[4]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[4]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }
                        } elseif ($descripcionRol == 'administrador') {
                            //gestionar compra abm
                            $objAbmGestionar = new AbmMenu;
                            $colMenusGestionar = $objAbmGestionar->buscar(['idpadre' => $colMenurol[5]->getObjMenu()->getIdmenu()]); // busco el primer menu "cerrar sesion" si tiene hijas con su id     

                            //configurar Administrador
                            $objAbmAdmin = new AbmMenu;
                            $colMenusAdmin = $objAbmAdmin->buscar(['idpadre' => $colMenurol[6]->getObjMenu()->getIdmenu()]); // busco el primer menu "cerrar sesion" si tiene hijas con su id     
                            ?> 

                            <!-- Barra de búsqueda -->
                            <div class="flex-grow-1 px-3">
                                <input type="search" class="form-control border-0 border-bottom rounded-0"
                                    placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                            </div>

                            <?php
                            // hogar
                            if ($colMenusHogar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Hogar</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusHogar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Hogar   
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[0]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Productos
                            if ($colMenusProductos != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Productos</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusProductos as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Productos
                                if ($colMenurol[1]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[1]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // carrito                            
                            if ($colMenusCarrito != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Carrito</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCarrito as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Carrito
                                if ($colMenurol[3]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[3]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // mi perfil =============================================
                            if ($colMenusMiPerfil != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusMiPerfil as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Mi perfil
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[2]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Gestionar compra 
                            //echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
                            if ($colMenusGestionar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusGestionar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Gestionar compra 
                                if ($colMenurol[5]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[5]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Administrador
                            //echo '<a href="configurarAdmin.php" class="text-white me-4 text-decoration-none">Administrador</a>';
                            if ($colMenusAdmin != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[6]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[6]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusAdmin as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Administrador
                                if ($colMenurol[6]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[6]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[6]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[6]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // cerrar sesion
                            if ($colMenusCerrar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Cerrar Sesion</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCerrar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Cerrar sesión
                                if ($colMenurol[4]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[4]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }
                        } elseif ($descripcionRol == 'deposito') {

                            ?> <!-- Barra de búsqueda -->
                            <div class="flex-grow-1 px-3">
                                <input type="search" class="form-control border-0 border-bottom rounded-0"
                                    placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                            </div>

                            <?php
                            //gestionar compra abm
                            $objAbmGestionar = new AbmMenu;
                            $colMenusGestionar = $objAbmGestionar->buscar(['idpadre' => $colMenurol[5]->getObjMenu()->getIdmenu()]); // busco el primer menu "cerrar sesion" si tiene hijas con su id     

                            ?> 

                        <?php
                            // hogar
                            if ($colMenusHogar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Hogar</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusHogar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Hogar   
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[0]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Productos
                            if ($colMenusProductos != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Productos</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusProductos as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Productos
                                if ($colMenurol[1]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[1]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // carrito                            
                            if ($colMenusCarrito != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Carrito</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCarrito as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Carrito
                                if ($colMenurol[3]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[3]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // mi perfil 
                            if ($colMenusMiPerfil != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusMiPerfil as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Mi perfil
                                if ($colMenurol[2]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[2]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // Gestionar compra 
                            //echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
                            if ($colMenusGestionar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Mi Perfil</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusGestionar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Gestionar compra 
                                if ($colMenurol[5]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[5]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }

                            // cerrar sesion
                            if ($colMenusCerrar != null) {
                                echo '<ul class="navbar-nav">';
                                echo '<li class="nav-item dropdown">';
                                echo '<a class="nav-link dropdown-toggle text-white fw-bold me-4 text-decoration-none" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones de Cerrar Sesion</a>';
                                echo "<ul class='dropdown-menu'>";
                                echo '<li><a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></li>';
                                foreach ($colMenusCerrar as $opcion) {
                                    if ($opcion->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<li><a href="' . $opcion->getMedescripcion() . '"  class="dropdown-item text-black fw-bold me-4 text-decoration-none">' . $opcion->getMenombre() . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</li>';
                                echo '</ul>';
                            } else {
                                // Cerrar sesión
                                if ($colMenurol[4]->getObjMenu()->getObjMenu() == null) {
                                    if ($colMenurol[4]->getObjMenu()->getMedeshabilitado() == '0000-00-00 00:00:00') {
                                        echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
                                    }
                                }
                            }
                        }
                    } else {
                        ?>
                        <html>
                        <!-- Barra de búsqueda -->
                        <div class="flex-grow-1 px-3">
                            <input type="search" class="form-control border-0 border-bottom rounded-0"
                                placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                        </div>
                        <!-- Enlaces principales -->
                        <a href="menu.php" class="text-white fw-bold me-4 text-decoration-none">Hogar</a>
                        <a href="productos.php" class="text-white me-4 text-decoration-none">Productos</a>
                        <!-- Enlaces adicionales -->
                        <div class="d-flex align-items-center">
                            <a href="carrito.php" class="text-white  me-4 text-decoration-none">Carrito </a>
                            <a href="iniciar_sesion.php" class="text-white text-decoration-none">Iniciar Sesión</a>
                        </div>

                        </html>
                    <?php
                    }

                    ?>

                    <html>
                </div>
        </nav>

    </header>

    <main class="container">