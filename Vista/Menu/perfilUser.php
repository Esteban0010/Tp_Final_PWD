<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
$objAbmUsuario = new AbmUsuario;
$session = new Session;
$datos = $session->getUsuario();
$id = $datos->getId();
verEstructura($datos);

if (isset($id) && $id <> -1) {
    $listaTabla = $objAbmUsuario->buscar($id);

    if (count($listaTabla) > 0) {
        $usuario = $listaTabla[0];
    }
} else {
    echo "<div>no hay datos cargados</div>";
}
?>


<div class="container mt-5">
    <h1 class="text-center">Mi Perfil</h1>


    <form id="fm" class="mt-4" style="width: 100%; max-width: 600px; margin: 0 auto;">
        <div class="row">

            <!-- ID -->
            <input type="hidden" id="id" name="id" value="<?php echo $usuario->getId(); ?>">

            <!-- Nombre -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="nombre" class="form-label me-3">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control me-3" value="<?php echo $usuario->getNombre(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('nombre')">Editar</button>
            </div>

            <!-- Mail -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="mail" class="form-label me-3">Mail</label>
                <input type="text" id="mail" name="mail" class="form-control me-3" value="<?php echo $usuario->getMail(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('mail')">Editar</button>
            </div>

            <!-- Contraseña actual -->
            <div class="col-md-12 mb-3 d-flex align-items-center" id="passwordActualContainer">
                <label for="password" class="form-label me-3">Contraseña Actual</label>
                <input type="password" id="password" name="password" class="form-control me-3" value="<?php echo $usuario->getPassword(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('password')">Editar</button>
            </div>

            <!-- Nueva contraseña (inicialmente oculta con "d-none") -->
            <div class="col-md-12 mb-3 d-none align-items-center" id="nuevaPasswordContainer">
                <label for="nuevaPassword" class="form-label me-3">Nueva Contraseña</label>
                <input type="password" id="nuevaPassword" name="nuevaPassword" class="form-control me-3" placeholder="Nueva contraseña" oninput="validarContrasenias()">
                <br>
                <label for="repetirPassword" class="form-label me-3">Repetir Contraseña</label>
                <input type="password" id="repetirPassword" name="repetirPassword" class="form-control me-3" placeholder="Repetir contraseña" oninput="validarContrasenias()">
                <br>
                <span id="mensajeError" class="text-danger d-none">Contraseñas no coincidentes</span>
            </div>


            <!-- Botón de guardar -->
            <div class="d-flex justify-content-center mt-4">
                <button type="button" id="guardarBtn" class="btn btn-primary" onclick="guardarCambios()" disabled>Guardar Cambios</button>
            </div>
    </form>

</div>

<br> <br> <br>
<script>
    function editarCampo(campoId) {
        const guardarBtn = $('#guardarBtn');

        if (campoId === 'password') {
            // Ocultar el contenedor de Contraseña Actual
            $('#passwordActualContainer').addClass('d-none');

            // Mostrar el contenedor para Nueva Contraseña
            $('#nuevaPasswordContainer').removeClass('d-none');
            $('#nuevaPassword').focus();
        } else {
            // Habilitar edición para otros campos
            const campo = document.getElementById(campoId);
            campo.removeAttribute('readonly'); // Habilitar edición
            campo.focus(); // Colocar el foco en el campo
            guardarBtn.removeAttr('disabled');

        }



    }

    function validarContrasenias() {
        const nuevaPassword = $('#nuevaPassword').val();
        const repetirPassword = $('#repetirPassword').val();
        const mensajeError = $('#mensajeError');
        const guardarBtn = $('#guardarBtn');

        if (nuevaPassword === repetirPassword && nuevaPassword.length > 5) {
            // Las contraseñas coinciden
            mensajeError.addClass('d-none'); // Ocultar mensaje de error
            guardarBtn.removeAttr('disabled'); // Habilitar botón de guardar
        } else {
            // Las contraseñas no coinciden
            mensajeError.removeClass('d-none'); // Mostrar mensaje de error
            guardarBtn.attr('disabled', true); // Deshabilitar botón de guardar
        }
    }

    function guardarCambios() {
        var formData = $('#fm').serialize();



        $.ajax({
            url: 'Action/actionActualizarPerfil1.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.respuesta) {
                    alert(response.mensaje || 'Cambios guardados correctamente.');

                } else {
                    alert(response.errorMsg || 'Hubo un error al guardar los cambios.');
                }
            },
            error: function() {
                alert('Error al conectar con el servidor.');
            }
        });

        const contraseniaactual = $('#passwordActualContainer').val;
        $('#nuevaPassword').val = contraseniaactual;

        $('#nuevaPasswordContainer').addClass('d-none'); // Ocultar nueva contraseña
        $('#passwordActualContainer').removeClass('d-none'); // Mostrar contraseña actual

        // Deshabilitar el botón de guardar nuevamente
        $('#guardarBtn').attr('disabled', true);


    }
</script>




<?php
include_once "../Estructura/Footer.php";
?>