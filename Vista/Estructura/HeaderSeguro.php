<?php
include_once("../../configuracion.php");
$datos = data_submitted();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerce seguro</title>

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


    } else {
        $mensaje = "Error, vuelva a iniciar sesion";
        header("Location: iniciar_sesion.php?msg=" . urlencode($mensaje));
    }

    ?>

    <header>
        <nav class="navbar navbar-expand-lg bg-white easyui-linkbutton" style="width:100%;">

            <?php
            $descripcionRol = $objRol->getDescripcion();

            if ($descripcionRol == 'cliente') {

                //home
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></span>';
                // prodcutos
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '  class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></span>';
                // buscador
                echo '<input class="easyui-searchbox" data-options="prompt:\'Buscar Producto...\',searcher:doSearch" style="width:50%;">';
                // cerrar sesion
                echo '<span class="me-3"><a class="text-decoration-none" href=' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '>' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></span>';
                // carrito
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" class="easyui-linkbutton" data-options="plain:true">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></span>';
                // mi perfil
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></span>';
            } elseif ($descripcionRol == 'deposito') {
                //home
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></span>';
                // prodcutos
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '  class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></span>';
                // buscador
                echo '<input class="easyui-searchbox" data-options="prompt:\'Buscar Producto...\',searcher:doSearch" style="width:50%;">';
                // cerrar sesion
                echo '<span class="me-3"><a class="text-decoration-none" href=' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '>' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></span>';
                // carrito
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" class="easyui-linkbutton" data-options="plain:true">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></span>';
                // mi perfil
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></span>';
                // Gestion de Compras
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
            } elseif ($descripcionRol == 'administrador') {
                //home
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[0]->getObjMenu()->getMenombre()) . '</a></span>';
                // prodcutos
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMedescripcion()) . '  class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[1]->getObjMenu()->getMenombre()) . '</a></span>';
                // buscador
                echo '<input class="easyui-searchbox" data-options="prompt:\'Buscar Producto...\',searcher:doSearch" style="width:50%;">';
                // cerrar sesion
                echo '<span class="me-3"><a class="text-decoration-none" href=' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMedescripcion()) . '>' . htmlspecialchars($colMenurol[4]->getObjMenu()->getMenombre()) . '</a></span>';
                // carrito
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" class="easyui-linkbutton" data-options="plain:true">' . htmlspecialchars($colMenurol[3]->getObjMenu()->getMenombre()) . '</a></span>';
                // mi perfil
                echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[2]->getObjMenu()->getMenombre()) . '</a></span>';
                // Administrador
                //echo '<span class="me-3"><a href=' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMedescripcion()) . ' class="text-decoration-none" data-options="plain:true">' . htmlspecialchars($colMenurol[5]->getObjMenu()->getMenombre()) . '</a></span>';
                echo '<span class="me-3"><a href="configurarAdmin.php" class="text-decoration-none" data-options="plain:true">Administrador</a></span>';
            } else {
                //home
                echo '<span class="me-3"><a href="menu.php" class="text-decoration-none" data-options="plain:true"></a></span>';
                // prodcutos
                echo '<span class="me-3"><a href="productos.php" class="text-decoration-none" data-options="plain:true">Productos</a></span>';
                // buscador
                echo '<input class="easyui-searchbox" data-options="prompt:\'Buscar Producto...\',searcher:doSearch" style="width:50%;">';
                // iniciar sesion
                echo '<span class="me-3"><a href="iniciar_sesion.php" class="text-decoration-none" data-options="plain:true">Iniciar Sesion</a></span>';
                // carrito
                echo '<span class="me-3"><a href="carrito.php" class="text-decoration-none" class="easyui-linkbutton" data-options="plain:true">Carrito</a></span>';
            }
            ?>

        </nav>
    </header>

    <main class="container">

        <h2>pagina segura</h2>