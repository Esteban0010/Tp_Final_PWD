<?php
include_once("../../configuracion.php");
include_once "../Estructura/HeaderSeguro.php";

// $session = new Session();

// $reistrado = $session->validar();
?>

<div class="container ">
    <div class="wrapper wrapper-content animated fadeInRight" style="min-height: 80vh">
        <div class="row">
            <!-- Columna de Productos -->
            <div class="col-md-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong id="item-count">0</strong>) productos</span>
                        <h5>Productos seleccionados</h5>
                    </div>
                    <!-- Contenedor de productos -->
                    <div id="productos-container"></div>
                </div>
            </div>
            <!-- Columna de Resumen -->
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Resumen de compra</h5>
                    </div>
                    <div class="ibox-content">
                        <span>Total</span>
                        <h2 class="font-bold" id="cart-total">$0.00</h2>
                        <hr>
                        <div class="m-t-sm">
                            <div class="btn-group">
                                <btn id="btn-pagar" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Pagar</btn>
                                <btn id="btn-cancelar" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancelar</btn>
                                <a href="#" class="btn btn-white btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Recuperar los productos del localStorage
        const productos = JSON.parse(localStorage.getItem('carrito')) || [];

        // Actualizar cantidad de ítems en el carrito
        $('#item-count').text(productos.length);

        // Contenedor de los productos
        const $productosContainer = $('#productos-container');

        // Función para calcular el total
        function calcularTotal(carrito) {
            let total = 0;
            carrito.forEach(producto => {
                total += producto.precio * producto.cantidad; // Utilizamos producto.precio
            });
            return total.toFixed(2); // Retornamos el total con 2 decimales
        }

        // Variable para el total
        let total = calcularTotal(productos); // Calculamos el total al inicio

        // Recorrer los productos y generar HTML
        productos.forEach(producto => {
            const productoHTML = `
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table shoping-cart-table">
                        <tbody>
                            <tr>
                                <td>
                                <div class="cart-product-imitation text-center">
                                <i class="fa fa-box fa-2x"></i>
                                <img src="${producto.img}" alt="producto" class="w-50">
                                </div>
                                </td>
                                <td class="desc">
                                    <h3>
                                        <a href="#" class="text-navy">
                                            ${producto.nombre}
                                        </a>
                                    </h3>
                                    <p class="small">
                                        ${producto.descripcion}
                                    </p>
                                    <div class="m-t-sm">
                                        <a href="#" class="text-muted remove-item" data-id="${producto.id}"><i class="fa fa-trash"></i> Remover producto</a>
                                    </div>
                                </td>
                                <td>
                                    $${producto.precio}  <!-- Usamos producto.precio -->
                                </td>
                                <td width="65">
                                    <input type="text" class="form-control text-center" value="${producto.cantidad}">
                                </td>
                                <td>
                                    <h4>
                                        $${(producto.precio * producto.cantidad).toFixed(2)} <!-- Calculamos subtotal -->
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
            $productosContainer.append(productoHTML);
        });

        // Actualizar total en el resumen del carrito
        $('#cart-total').text(`$${total}`);

        // Evento para eliminar productos
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const nuevoCarrito = productos.filter(producto => producto.id !== id);
            localStorage.setItem('carrito', JSON.stringify(nuevoCarrito));

            // Recalcular el total después de eliminar un producto
            total = calcularTotal(nuevoCarrito); // Recalculamos el total
            $('#cart-total').text(`$${total}`); // Actualizamos el total en la UI

            // Recargar la página para reflejar los cambios
            location.reload();
        });
    });


    $(document).on('click', '#btn-cancelar', function() {
    // Vaciar el carrito del localStorage
    localStorage.removeItem('carrito');

    // Actualizar la cantidad de ítems en el carrito
    $('#item-count').text('0');

    // Mostrar el mensaje de "Compra cancelada"
    const $productosContainer = $('#productos-container');
    $productosContainer.html(`
        <div class="alert alert-warning text-center" role="alert">
            <strong>Compra cancelada.</strong> No tienes productos en tu carrito.
        </div>
    `);

    // Actualizar el total en el resumen del carrito
    $('#cart-total').text('$0.00');
});

    $(document).on('click', '#btn-pagar', function() {
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        if (carrito.length === 0) {
            alert('El carrito está vacío. Agrega productos antes de pagar.');
            return;
        }

        // Verificar si el usuario está logueado
        $.ajax({
            url: './Action/actionVerificarSesion.php', // Ruta al archivo de verificación
            method: 'GET',
            dataType: 'json',
            success: function(response) {

                if (response.logged_in) {
                    // Si está logueado, proceder con la compra
                    realizarCompra(carrito);
                } else {
                    alert('Debes iniciar sesión para realizar la compra.');
                    window.location.href = './login.php'; // Redirigir al login si no está logueado
                }
            },

            error: function() {
                alert('Hubo un error al verificar la sesión.');
            }
        });
    });

    // Función para realizar la compra
    function realizarCompra(carrito) {
        $.ajax({
            url: './Action/actionEjecutarCompra.php',
            method: 'POST',
            data: {
                carrito: JSON.stringify(carrito)
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Compra realizada con éxito.');
                    localStorage.removeItem('carrito');
                    location.reload();
                } else {
                    alert('Error al realizar la compra: ' + response.message);
                }
            },
            error: function() {
                alert('No se pudo ejecutar la operacion');
            }
        });
    }
</script>
<?php
include_once "../Estructura/Footer.php";
?>