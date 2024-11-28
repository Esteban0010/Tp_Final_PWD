
$(document).ready(function () {
    $(".change-state").click(function (e) {
        e.preventDefault();

        //no hacer la accion si el boton esta deshab
        if ($(this).prop('disabled')) {
            return;
        }

        var idCompraEstado = $(this).data('id');
        var nuevoEstado = $(this).data('state');
        var $button = $(this);

        $.ajax({
            url: 'Action/cambiarEstado.php',
            type: 'POST',
            data: {
                idCompraEstado: idCompraEstado,
                estado: nuevoEstado
            },
            success: function (response) {
                // Procesar la respuesta JSON correctamente
                if (response.mensaje) {
                    mensaje(response.mensaje, 'success');
                } else {
                    mensaje("Error");
                }

                //cambiar estado de la tabla
                var estadoText = '';
                switch (nuevoEstado) {
                    case 2:
                        estadoText = 'Aceptada';
                        break;
                    case 3:
                        estadoText = 'Enviada';
                        break;
                    case 4:
                        estadoText = 'Cancelada';
                        break;
                }

                // Actualizar estado y fecha en la tabla
                var $row = $button.closest('tr');
                $row.find('td').eq(1).text(estadoText); // Columna de estado
                $row.find('td').eq(3).text(response.fechaFin); // Columna de fecha fin

                //deshab botones segun estado
                var $row = $button.closest('tr');
                if (nuevoEstado == 2) {
                    $row.find('button[data-state="2"]').prop('disabled', true).addClass(
                        'btn-secondary');
                } else if (nuevoEstado == 3) {
                    $row.find('button[data-state="2"], button[data-state="3"]').prop(
                        'disabled', true).addClass('btn-secondary');
                } else if (nuevoEstado == 4) {
                    $row.find('button').prop('disabled', true).addClass('btn-secondary');
                }
            },
            error: function () {
                mensaje("Ocurrió un error al cambiar el estado.", 'danger');
            }
        });
    });
});












//funcion para mostrar msj dinamic
function mensaje(msj, type) {
    var msjDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert"></div>');
    msjDiv.text(msj);
    msjDiv.append(
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
    );

    //msj al contenedor
    $("#mensaje").html(msjDiv);
}

