// $(document).ready(function () {
//     // Cuando se hace clic en el botón "Comprar"
//     $(document).on('click', '.btn-comprar', function () {
//         const productId = $(this).data('id');
//         const quantity = parseInt($('#cantidad-' + productId).val());

//         // Verificar stock con AJAX
//         $.ajax({
//             url: './Action/verificarStock.php',
//             method: 'POST',
//             data: { idProducto: productId, cantidad: quantity },
//             dataType: 'json',
//             success: function (response) {
//                 if (response.success) {
//                     alert('¡Producto agregado al carrito!');
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function () {
//                 alert('Error al verificar el stock.');
//             }
//         });
//     });
// });