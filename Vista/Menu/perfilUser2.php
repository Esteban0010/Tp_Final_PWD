<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";


?>

<div class="container mt-5">
    <h1 class="text-center">Mi Perfil</h1>
    <form action="actualizarPerfil.php" method="POST" class="mt-4">
        <div class="row">
            <!-- Nombre -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="nombre" class="form-label me-3">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control me-3" value="<?php echo $usuario['nombre']; ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('nombre')">Editar</button>
            </div>

            <!-- Apellido -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="apellido" class="form-label me-3">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control me-3" value="<?php echo $usuario['apellido']; ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('apellido')">Editar</button>
            </div>

            <!-- Correo -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="email" class="form-label me-3">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control me-3" value="<?php echo $usuario['email']; ?>" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('email')">Editar</button>
            </div>

            <!-- Contraseña -->
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <label for="password" class="form-label me-3">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control me-3" placeholder="********" readonly>
                <button type="button" class="btn btn-secondary btn-sm" onclick="editarCampo('password')">Editar</button>
            </div>
        </div>

        <!-- Botón de guardar -->
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<script>
    // Función para alternar entre modo de edición y solo lectura
    function editarCampo(id) {
        const campo = document.getElementById(id);
        campo.readOnly = !campo.readOnly; // Alterna el modo de solo lectura
        campo.focus(); // Mueve el cursor al campo
    }
</script>