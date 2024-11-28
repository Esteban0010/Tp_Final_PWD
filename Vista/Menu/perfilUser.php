<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
if(!$resp) {
    header("Location: menu.php");   
}

$datos = $objTrans->getUsuario();
$id = $datos->getId();


?>


<div class="container mt-5">
    <h1 class="text-center">Mi Perfil</h1>


    <form id="fm" class="mt-4" style="width: 100%; max-width: 600px; margin: 0 auto;">
        <div class="row">

            <!-- ID -->
            <input type="hidden" id="id" name="id" value="<?php echo $datos->getId(); ?>">

            <!-- Nombre -->
            <div class="col-md-12 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <div class="input-group">
                    <input type="text" id="nombre" name="nombre" class="form-control"
                        value="<?php echo $datos->getNombre(); ?>" readonly>
                    <button type="button" class="btn btn-secondary btn-sm"
                        onclick="editarCampo('nombre')">Editar</button>
                    <div class="invalid-feedback">Por favor, ingrese un Nombre válido.</div>

                </div>
            </div>

            <!-- Mail -->
            <div class="col-md-12 mb-3">
                <label for="mail" class="form-label">Mail</label>
                <div class="input-group">
                    <input type="text" id="mail" name="mail" class="form-control"
                        value="<?php echo $datos->getMail(); ?>" readonly>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('mail')">Editar</button>
                    <div class="invalid-feedback">Por favor, ingrese un Correo válido.</div>

                </div>
            </div>

            <!-- Contraseña actual -->
            <div class="col-md-12 mb-3 " id="passwordActualContainer">

                <label for="password" class="form-label ">Contraseña Actual</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control " value="12345678"
                        readonly>
                    <button type="button" class="btn btn-secondary btn-sm"
                        onclick="editarCampo('password')">Editar</button>
                </div>
            </div>

            <!-- Nueva contraseña (inicialmente oculta con "d-none") -->
            <div class="col-md-12 mb-3 d-none align-items-center" id="nuevaPasswordContainer">
                <label for="nuevaPassword" class="form-label me-3">Nueva Contraseña</label>
                <input type="password" id="nuevaPassword" name="nuevaPassword" class="form-control me-3"
                    placeholder="Nueva contraseña">
                <br>
                <label for="repetirPassword" class="form-label me-3">Repetir Contraseña</label>
                <input type="password" id="repetirPassword" name="repetirPassword" class="form-control me-3"
                    placeholder="Repetir contraseña">
                <br>
                <span id="mensajeError" class="text-danger d-none">Contraseñas no coincidentes</span>
            </div>


            <div id="mensajeResultado" class="d-none mt-3 "> </div>


            <!-- Botón de guardar -->
            <div class="d-flex justify-content-center mt-4">
                <button type="button" id="guardarBtn" class="btn btn-primary" onclick="guardarCambios()"
                    disabled>Guardar Cambios</button>
            </div>


        </div>


    </form>

</div>

<br> <br> <br>

<script src="../Asets/js/perfilUser.js"></script>



<?php
include_once "../Estructura/Footer.php";
?>