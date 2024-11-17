<?php
include_once("../../configuracion.php");
include_once "../Estructura/Header.php";
$datos = data_submitted();
$objControl = new AbmProducto();
$List_Producto = $objControl->buscar(null);
?>
<h1>Productos</h1>

<?php
if (count($List_Producto) > 0) {
    echo "<div id=\"cc\" class=\"easyui-layout\" style=\"width:100%; min-height:300px; overflow:auto;\">";

    // Contenedor con clases Bootstrap
    echo "<div class=\"container-fluid p-2\" style=\"background:#fff;\">";
    echo "<div class=\"row justify-content-center g-3\">";

    foreach ($List_Producto as $objProducto) {
        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">';
echo '<div id="card" name="card" class="card text-center border-dark h-100">';
echo '<div class="card-body">';
echo '<span class="card-title" data-id="' . $objProducto->getIdProducto() . '">' . $objProducto->getIdProducto() . '</span><br>';
echo '<span class="card-subtitle mb-2 text-muted" data-name="' . $objProducto->getProNombre() . '">' . $objProducto->getProNombre() . '</span><br>';
echo '<span class="card-text" data-detail="' . $objProducto->getProDetalle() . '">' . $objProducto->getProDetalle() . '</span><br>';
echo '<span class="card-text" data-stock="' . $objProducto->getProCantStock() . '">' . $objProducto->getProCantStock() . '</span><br>';
echo '<span class="card-text" data-price="' . $objProducto->getValor() . '">' . $objProducto->getValor() . '</span><br>';
// Select para elegir cantidad
echo '<label for="quantity-' . $objProducto->getIdProducto() . '">Cantidad:</label>';
echo '<select id="quantity-' . $objProducto->getIdProducto() . '" class="form-control quantity-select">';
for ($i = 1; $i <= $objProducto->getProCantStock(); $i++) {
    echo '<option value="' . $i . '">' . $i . '</option>';
}
echo '</select><br>';
// Botón para comprar
echo '<button class="btn btn-primary mt-2 buy-button" data-id="' . $objProducto->getIdProducto() . '">Comprar Producto</button>';
echo "</div>";
echo "</div>";
echo "</div>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div> No Hay Productos Cargados</div>";
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        // Evento para aumentar la cantidad
        $(document).on('click', '.quantity-increase', function () {
            const productId = $(this).data('id');
            const $input = $('#quantity-' + productId);
            const maxStock = parseInt($input.data('max'));
            let currentValue = parseInt($input.val());

            if (currentValue < maxStock) {
                $input.val(currentValue + 1);
            } else {
                alert('Cantidad máxima alcanzada.');
            }
        });

        // Evento para disminuir la cantidad
        $(document).on('click', '.quantity-decrease', function () {
            const productId = $(this).data('id');
            const $input = $('#quantity-' + productId);
            let currentValue = parseInt($input.val());

            if (currentValue > 1) {
                $input.val(currentValue - 1);
            }
        });

        // Evento al hacer clic en el botón "Comprar Producto"
        $(document).on('click', '.buy-button', function () {
            // Obtener el ID del producto
            const productId = $(this).data('id');
            const quantity = parseInt($('#quantity-' + productId).val());

            // Realizar solicitud AJAX para verificar el stock
            $.ajax({
                url: './Action/verificarStock.php',
                method: 'POST',
                data: { idProducto: productId, cantidad: quantity },
                dataType: 'json',
                success: function (response) {
    if (response.success) {
        // Obtener la tarjeta del producto
        const card = $(`[data-id="${productId}"]`).closest('.card-body');
        const productName = card.find('[data-name]').data('name');
        const productDetail = card.find('[data-detail]').data('detail');
        const productPrice = card.find('[data-price]').data('price');

        // Crear el objeto del producto
        const product = {
            id: productId,
            nombre: productName,
            descripcion: productDetail,
            precio: productPrice,
            cantidad: quantity
        };

        // Obtener el carrito del localStorage
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Buscar si el producto ya está en el carrito
        const existingProductIndex = carrito.findIndex(p => p.id === productId);

        if (existingProductIndex !== -1) {
            // Si ya está en el carrito, actualizamos la cantidad
            carrito[existingProductIndex].cantidad += quantity;

            // Verificamos que no exceda el stock disponible
            if (carrito[existingProductIndex].cantidad > response.stockDisponible) {
                alert('Cantidad seleccionada excede el stock disponible.');
                carrito[existingProductIndex].cantidad = response.stockDisponible; // Ajustar al máximo permitido
            } else {
                alert('Cantidad actualizada en el carrito.');
            }
        } else {
            // Si no está en el carrito, lo agregamos
            carrito.push(product);
            alert('Producto agregado al carrito.');
        }

        // Guardar el carrito actualizado en el localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));
    } else {
        alert(response.message); // Mostrar mensaje de error si no hay stock
    }
},
                error: function () {
                    alert('Error al verificar el stock.');
                }
            });
        });
    });
</script>

<?php
include_once "../Estructura/Footer.php";
?>
