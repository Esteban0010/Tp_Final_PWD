function validarContrasenias(nuevaPassword, repetirPassword) {
    const mensajeError = $('#mensajeError');
    const guardarBtn = $('#guardarBtn');

    if ( nuevaPassword === repetirPassword && nuevaPassword.length > 5 ) {
        // Las contraseñas coinciden
        $('#password').val(nuevaPassword);
        mensajeError.addClass('d-none'); // Ocultar mensaje de error
        guardarBtn.removeAttr('disabled'); // Habilitar botón de guardar
    } else {
        // Las contraseñas no coinciden
        mensajeError.removeClass('d-none'); // Mostrar mensaje de error
        guardarBtn.attr('disabled', true); // Deshabilitar botón de guardar
    }
}

function editarCampo(campoId) {
    const guardarBtn = $('#guardarBtn');

    if (campoId === 'password') {
        
        // Ocultar el contenedor de Contraseña Actual
        $('#passwordActualContainer').addClass('d-none');

        // Mostrar el contenedor para Nueva Contraseña
        $('#nuevaPasswordContainer').removeClass('d-none');
        $('#nuevaPassword').focus();
        //Limpiamos campos
        $('#nuevaPassword').val('');
        $('#repetirPassword').val('');
        // Validar contraseñas al escribir
        $('#nuevaPassword, #repetirPassword').on('input', function () {
            const nuevaPassword = $('#nuevaPassword').val();
            const repetirPassword = $('#repetirPassword').val();
            validarContrasenias(nuevaPassword, repetirPassword);
        });

    } else {
        //setear contraseña actual.
        const passwordActual = $('#password').val();
        $('#nuevaPassword').val(passwordActual);
        // Habilitar edición para otros campos
        const campo = document.getElementById(campoId);
        campo.removeAttribute('readonly'); // Habilitar edición
        campo.focus(); // Colocar el foco en el campo
        guardarBtn.removeAttr('disabled'); // Habilitar botón de guardar

    }
}


function mensaje(esExito) {
    var mensajeResultado = $('#mensajeResultado');

    // Limpio clases y texto previos
    mensajeResultado
        .removeClass('d-none alert-success alert-danger')
        .text(''); // Limpio el mensaje anterior

    // Configuro el mensaje según el resultado
    if (esExito) {
        mensajeResultado
            .addClass('alert alert-success')
            .html('<i class="bi bi-check-circle me-2"></i>Cambios guardados correctamente.');
    } else {
        mensajeResultado
            .addClass('alert alert-danger')
            .html('<i class="bi bi-exclamation-circle me-2"></i>No se guardaron los cambios.');
    }

    // Muestro el mensaje
    mensajeResultado.removeClass('d-none');
}

    function guardarCambios() {
  var valido = true;
    
  // Names del formulario
         var correo = $('#mail');
         var nombre = $('#nombre');

              // Limpio clases
              correo.removeClass('is-invalid is-valid');
       nombre.removeClass('is-invalid is-valid');

       // Nombre
        if (!/^[a-zA-Z\s]+$/.test(nombre.val())) {
            nombre.addClass('is-invalid');
            valido = false;
        } else {
            nombre.addClass('is-valid');
        }

//mail
if (!/@/.test(correo.val())) {
    correo.addClass('is-invalid');
    valido = false;
} else {
    correo.addClass('is-valid');
}

        //AJAX
        if(valido){        
            
            var formData = $('#fm').serialize();
           $.ajax({
            url: 'Action/actionActualizarPerfil1.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.respuesta) {

                    mensaje(true)

                } else {
                    alert( 'Hubo un error al guardar los cambios.');
                }
            },
            error: function() {
                alert('Error al conectar con el servidor.');
            }
        });   
        }else{
            mensaje( false)
        }


        $('#nuevaPasswordContainer').addClass('d-none'); // Ocultar nueva contraseña
        $('#passwordActualContainer').removeClass('d-none'); // Mostrar contraseña actual

        // Deshabilitar el botón de guardar nuevamente
        $('#guardarBtn').attr('disabled', true);
      
    }


