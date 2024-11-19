<?php
include_once("../../configuracion.php");
$datos = data_submitted();
//verEstructura($datos);
?>

<?php
$objTrans = new Session();
$resp = $objTrans->validar();
if ($resp) {
    //echo("<script>location.href = '../home/index.php';</script>");
} else {
    $mensaje = "Error, vuelva a iniciar sesion";
    header("Location: iniciar_sesion.php?msg=" . urlencode($mensaje));
}
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

    <header>
        <nav class="navbar navbar-expand-lg bg-white easyui-linkbutton" style="width:100%;">


            <span class="me-3"><a href="menu.php" class="text-decoration-none" data-options="plain:true">Hogar</a></span>

            <span class="me-3"><a href="productos.php" class="text-decoration-none" data-options="plain:true">Productos</a></span>
            
            <input class="easyui-searchbox" data-options="prompt:'Buscar Producto...',searcher:doSearch" style="width:50%;">
            <!-- <a href="iniciar_sesion.php" class="easyui-linkbutton" data-options="plain:true">Iniciar Sesion</a> -->
            
            <span class="me-3"><a class="text-decoration-none" href="Action/actionVerificarLogin.php?accion=cerrar">Cerrar Sesion</a></span>

            <span class="me-3"><a href="carrito.php" class="text-decoration-none" class="easyui-linkbutton" data-options="plain:true">Carrito</a></span>

            <span class="me-3"><a href="perfilUser.php" class="text-decoration-none" data-options="plain:true">Mi perfil </a></span>

        </nav>
    </header>

    <main class="container mt-2">

        <h2>pagina segura</h2>