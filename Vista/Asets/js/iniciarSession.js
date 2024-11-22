//ajax iniciar session.
function guardarCambios() {
    
          //AJAX
              
              var formData = $('#fm').serialize();
             $.ajax({
             type: 'POST',
              url: 'Action/actionVerificarLogin.php',
              data: formData,
              dataType: 'json',
              success: function(response) {
                if (response.respuesta) {
  
                      mensaje(response)
                     
                  } else {
                      mensaje(response);
                  }
              },
              error: function() {
                  mensaje(response);
              }
          });   
         
        
      }

      function mensaje(response) {
        var mensajeResultado = $('#mensajeResultado');
    
        // Limpio clases y texto previos
        mensajeResultado
            .removeClass('d-none alert-success alert-danger')
            .text(''); // Limpio el mensaje anterior
    
        // Configuro el mensaje según el resultado
        if (response.respuesta === 1 ) {
            mensajeResultado
                .addClass('alert alert-success')
                .html('<i class="bi bi-check-circle me-2"></i>Bienvenido inicio de sesion correcto');
                window.location.href = response.redirect;
        } else if ((response.respuesta).val === 2) {
            mensajeResultado
                .addClass('alert alert-danger')
                .html('<i class="bi bi-exclamation-circle me-2"></i> Error, usuario o password incorrecto');
                 window.location.href = response.redirect;

        }else if(response.respuesta === 3 ){
             window.location.href = response.redirect;      
          // Muestro el mensaje
             mensajeResultado.addClass('alert alert-primary').html('<i class="bi bi-exclamation-circle me-2"></i> Gracias por visitarnos!');
        }


                       mensajeResultado.removeClass('d-none');

        }
       

    