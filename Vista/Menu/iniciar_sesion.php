<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";
$datos = data_submitted();
?>

<div class="container d-flex justify-content-center align-items-center" id="container" style="height: 79vh;">

    <form action="Action/actionVerificarLogin.php" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow" style="width: 100%; max-width: 400px;" onclick="validar()">

        <h2 class="text-center mb-2">Iniciar Sesion</h2>

        <div class="mb-3">

            <?php
            if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
                if ($datos['msg'] == 'Error, usuario o password incorrecto' || $datos['msg'] == 'Error, vuelva a iniciar sesion') {
                    echo "<div class='alert alert-danger text-center mb-1' style='height: 37.6px;'>";
                    echo "<label style='position: absolute; margin: -10px; left: 70px;'>";
                    echo $datos['msg'];
                    echo "</label>";
                    echo "</div>";
                } elseif ($datos['msg'] == 'Session Cerrada.') {
                    echo "<div class='alert alert-info text-center mb-1' style='height: 37.6px;'>";
                    echo "<label style='position: absolute; margin: -10px; left: 130px;'>";
                    echo $datos['msg'];
                    echo "</label>";
                    echo "</div>";
                } else {
                    echo "<div class='alert alert-success text-center mb-1' style='height: 37.6px;'>";
                    echo "<label style='position: absolute; margin: -10px; left: 120px;'>";
                    echo $datos['msg'];
                    echo "</label>";
                    echo "</div>";
                }
            }
            ?>

            <!-- usnombre -->
            <label for="usnombre" class="form-label my-1">Nombre de Usuario:</label>
            <input type="text" id="usnombre" name="usnombre" class="form-control" placeholder="Ingrese un Nombre de Usuario..." required>

            <!-- uspass -->
            <label for="text" class="form-label my-1">Password:</label>
            <input type="pass" id="uspass" name="uspass" class="form-control" placeholder="Ingrese un Password..." required>

            <input type="hidden" id="accion" name="accion" value="login">
            <!-- hidden -->
            <!-- <input type="hidden" id="deshabilitado" name="deshabilitado" class="form-control" value="<?php //echo '0000-00-00 00:00:00'; 
                                                                                                            ?>"> -->
            <!-- date('Y-m-d H:i:s') -->
        </div>

        <!-- botones  -->
        <button type="submit" class="btn btn-success w-100">Enviar</button>
        <div class="my-1"><a class="btn btn-primary w-100" role="button" href="registrarse.php?">Registrarse</a></div>

    </form>

</div>

<!-- js validacion formulario -->
<script src="../Asets/js/md5.js"></script>
<?php
include_once "../Estructura/Footer.php";
?>