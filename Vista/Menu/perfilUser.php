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
        verEstructura($usuario);
    }
} else {
    echo "<div>no hay datos cargados</div>";
}
?>


<div class="container mt-5">
    <h1 class="text-center">Mi Perfil</h1>

    <form id="fm" class="mt-4" style="width: 100%; max-width: 600px; margin: 0 auto;">
        <div class="row">
            <!-- Nombre -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="nombre" class="form-label me-3">Nombre</label>
                <input type="hidden" id="id" name="id" value="<?php echo $usuario->getId(); ?>">
                <input type="text" id="nombre" name="nombre" class="form-control me-3" value="<?php echo $usuario->getNombre(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('nombre')">Editar</button>
            </div>

            <!-- Mail -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="mail" class="form-label me-3">Mail</label>
                <input type="text" id="mail" name="mail" class="form-control me-3" value="<?php echo $usuario->getMail(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('mail')">Editar</button>
            </div>

            <!-- Contraseña -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="password" class="form-label me-3">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control me-3" value="<?php echo $usuario->getPassword(); ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('password')">Editar</button>
            </div>
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
        const campo = document.getElementById(campoId);
        campo.removeAttribute('readonly'); // Habilitar edición
        campo.focus(); // Colocar el cursor en el campo
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
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
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