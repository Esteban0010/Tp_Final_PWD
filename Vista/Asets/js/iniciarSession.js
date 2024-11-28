//ajax iniciar session.
function guardarCambios() {
    
    var valido = true;
    
    // Names del formulario
    var pass = $('#uspass');
    var nombre = $('#usnombre');
    
    // Limpio clases
    pass.removeClass('is-invalid is-valid');
    nombre.removeClass('is-invalid is-valid');
    
      // no valida  el nombre si esta vacio el campo 
      if (nombre.val().trim() === "") {
        nombre.addClass('is-invalid');
        valido = false;
    } else {
        nombre.addClass('is-valid');
    }

      // no valida  el correo si esta vacio el campo 
      if (pass.val().trim() === "" ) {
        pass.addClass('is-invalid');
        valido = false;
    } else {
        pass.addClass('is-valid');
    }
    
  
    
        //AJAX

          //AJAX
          if(valido){        
            
            var formData = $('#fm').serialize();
           $.ajax({
            url: 'Action/actionVerificarLogin.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.respuesta) {
        
                    mensaje(response);
        
                } else {
                    mensaje(response);
                }
            },
            error: function() {
                mensaje(response);
            }
        });   
        }else{
            mensaje(response);
        }
      }


    
    function mensaje(response) {
      var mensajeResultado = $('#mensajeResultado');
    
      // Limpio clases y texto previos
      mensajeResultado
          .removeClass('d-none alert-success alert-danger')
          .text(''); // Limpio el mensaje anterior
    
          if (response.cerrar) {
            // mensajeResultado
            //     .addClass('alert alert-primary')
            //     .html('<i class="bi bi-exclamation-circle me-2"></i> Sesión cerrada correctamente.');
            window.location.href = response.redirect;
        }
      // Configuro el mensaje según el resultado
      if (response.respuesta) {
         window.location.href = response.redirect;
          mensajeResultado
              .addClass('alert alert-success')
              .html('<i class="bi bi-check-circle me-2"></i>Bienvenido ahora puede iniciar sesion ');
              
      } else if (response.respuesta === false) {
          mensajeResultado
              .addClass('alert alert-danger')
              .html('<i class="bi bi-exclamation-circle me-20"></i> Error, contraseña o usario erroneos.');
                // window.location.href = response.redirect;
    
      } 
      
      
             mensajeResultado.removeClass('d-none');
    
    }