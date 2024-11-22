<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";
$datos = data_submitted();
?>

<div class="container d-flex justify-content-center align-items-center" id="container" style="height: 79vh;">

    <form id="fm" action="Action/actionVerificarLogin.php" method="POST" enctype="multipart/form-data" class="bg-white p-3 rounded shadow" style="width: 100%; max-width: 400px;">

        <h2 class="text-center mb-2">Iniciar Sesion</h2>

        <div class="mb-3">
            <!-- usnombre -->
            <div>
                <label for="usnombre" class="form-label my-1">Nombre de Usuario:</label>
                <input type="text" id="usnombre" name="usnombre" class="form-control" placeholder="Ingrese un Nombre de Usuario..." required>
            </div>
            <!-- uspass -->
            <div>
                <label for="uspass" class="form-label my-1">Password:</label>
                <input type="password" id="uspass" name="uspass" class="form-control" placeholder="Ingrese un Password..." required>
                <div class="invalid-feedback"> Debe ingresar sus datos</div>
            </div>
            <input type="hidden" id="accion" name="accion" value="login">
            <!-- hidden -->
            <!-- <input type="hidden" id="deshabilitado" name="deshabilitado" class="form-control" value="<?php //echo '0000-00-00 00:00:00'; 
                                                                                                            ?>"> -->
            <!-- date('Y-m-d H:i:s') -->
        </div>
        <div id="mensajeResultado" class="d-none mt-3"> </div>
        <!-- botones  -->
        <button type="button" class="btn btn-success w-100" onclick="guardarCambios()">Enviar</button>
        <div class="my-1">
            <a class="btn btn-primary w-100" role="button" href="registrarse.php?">Registrarse</a>
        </div>

    </form>

</div>

<!-- js validacion formulario -->
<script src="../Asets/js/iniciarSession.js"></script>

<?php
include_once "../Estructura/Footer.php";
?>