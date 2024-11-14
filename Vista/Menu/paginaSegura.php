<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
$datos = data_submitted();
//print_r($datos);
//verEstructura($datos);
?>

    <?php
        $objTrans = new Session();
        $resp = $objTrans->validar();
        if($resp) {
        //echo("<script>location.href = '../home/index.php';</script>");
        } else {
            $mensaje ="Error, vuelva a iniciar sesion";
            header("Location: login.php?msg=" . urlencode($mensaje));
            exit();
        }
    ?>
    <div>
        <h1>Bienvenidos!</h1>
        <div class="my-1"><a class="btn btn-info w-20" role="button"href="listarUsuario.php">Lista de Usuarios</a></div>

        <div class="my-1"><a class="btn btn-secondary w-20" role="button" href="Action/actionVerificarLogin.php?accion=cerrar">Cerrar Sesion</a></div>
    </div>
<?php
include_once "../Estructura/Footer.php";
?>