<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";
$objAbmUsuario = new AbmUsuario;
$session = new Session;
$datos = $session->getUsuario();
$id = $datos->getId();

$obj = NULL;
if (isset($id) && $id <> -1) {
    $listaTabla = $objAbmUsuario->buscar($id);

    if (count($listaTabla) == 1) {
        $usuario = $listaTabla[0];
        // verEstructura($usuario);
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
                <input type="password" id="password" name="password" class="form-control me-3" value="******" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('password')">Editar</button>
            </div>

            <!-- Nueva contraseña (inicialmente oculto con "hidden") -->
            <div class="col-md-12 mb-3 d-flex align-items-center" id="nuevaPasswordContainer" style='display: none;'>
                <label for="nuevaPassword" class="form-label me-3">Nueva Contraseña</label>
                <input type="password" id="nuevaPassword" name="nuevaPassword" class="form-control">
            </div>


            <!-- Botón de guardar -->
            <div class="d-flex justify-content-center mt-4">
                <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
            </div>
    </form>
</div>

<!-- Scripts -->
<script>
    function editarCampo(campoId) {
        if (campoId === ' password') {
            // Ocultar el contenedor de contraseña actual
            document.getElementById('passwordActualContainer').style.display = 'none';

            // Mostrar el contenedor para la nueva contraseña
            const nuevaPasswordContainer = document.getElementById('nuevaPasswordContainer');
            nuevaPasswordContainer.style.display = 'flex';

            // Enfocar el campo de nueva contraseña
            document.getElementById('nuevaPassword').focus();
        } else {
            // Habilitar edición para otros campos
            const campo = document.getElementById(campoId);
            campo.removeAttribute('readonly');
            campo.focus();
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
                    // Redirige si es necesario
                    // if (response.redirect) {
                    // window.location.href=response.redirect;
                    // }
                } else {
                    alert(response.errorMsg || 'Hubo un error al guardar los cambios.');
                }
            },
            error: function() {
                alert('Error al conectar con el servidor.');
            }
        });
    }
</script>




<?php
include_once "../Estructura/Footer.php";
?>