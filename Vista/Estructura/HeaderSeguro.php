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
    $resp = $objTrans->validar();
    if ($resp) {
        //echo("<script>location.href = '../home/index.php';</script>");
        $objUsuario = $objTrans->getUsuario();
        $objRol = $objTrans->getRol();
        //verEstructura($objUsuario);
        //verEstructura($objRol);
        $colMenurol = $colObjMenus->buscar(['idrol' => $objRol->getId()]);
        //verEstructura($colMenurol);
        $descripcionRol = $objRol->getDescripcion();
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
                            // Home
                            echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                            // Productos
                            echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                            // Carrito
                            echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                            // Mi perfil
                            echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';
                            // Cerrar sesión
                            echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
                        } elseif ($descripcionRol == 'administrador') {
                        ?> <!-- Barra de búsqueda -->
                            <div class="flex-grow-1 px-3">
                                <input type="search" class="form-control border-0 border-bottom rounded-0"
                                    placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                            </div>

                        <?php
                            // Home
                            echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                            // Productos
                            echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                            // Carrito
                            echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                            // Mi perfil
                            echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';
                            // Administrador
                            echo '<a href="configurarAdmin.php" class="text-white me-4 text-decoration-none">Administrador</a>';
                            // Gestionar compra 
                            echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
                            // Cerrar sesión
                            echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
                        } elseif ($descripcionRol == 'deposito') {

                        ?> <!-- Barra de búsqueda -->
                            <div class="flex-grow-1 px-3">
                                <input type="search" class="form-control border-0 border-bottom rounded-0"
                                    placeholder="Buscar Producto..." aria-label="Buscar" style="box-shadow: none;">
                            </div>

                        <?php
                            // Home
                            echo '<a href="' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . '" class="text-white fw-bold me-4 text-decoration-none">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a>';
                            // Productos
                            echo '<a href="' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a>';
                            // Carrito
                            echo '<a href="' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a>';
                            // Mi perfil
                            echo '<a href="' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . '" class="text-white me-4 text-decoration-none">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a>';

                            // Gestionar compra 
                            echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
                            // Cerrar sesión
                            echo '<a href="' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '" class="text-white text-decoration-none">' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a>';
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

        <h2>pagina segura</h2>