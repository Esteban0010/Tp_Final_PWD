//ajax iniciar session.
function guardarCambios() {
    var valido = true;
    
// Names del formulario
 var password = $('#uspass');
var correo = $('#usmail');
var nombre = $('#usnombre');

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

//contraseña
if (!/^\d+$/.test(password.val()) ) {
    password.addClass('is-invalid');
    valido = false;
} else {
    password.addClass('is-valid');
}

    //AJAX

if(valido){        
            
    var formData = $('#fm').serialize();
   $.ajax({
    url: 'Action/actionRegistrar.php',
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

  // Configuro el mensaje según el resultado
  if (response.respuesta) {
    // window.location.href = response.redirect;
      mensajeResultado
          .addClass('alert alert-success')
          .html('<i class="bi bi-check-circle me-2"></i>Bienvenido ahora puede iniciar sesion ');
          
  } else if (response.respuesta === false) {
      mensajeResultado
          .addClass('alert alert-danger')
          .html('<i class="bi bi-exclamation-circle me-2"></i> Error, datos no registrados, usario existente');
        //    window.location.href = response.redirect;

  }
         mensajeResultado.removeClass('d-none');

}