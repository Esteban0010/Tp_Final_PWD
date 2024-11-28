$(document).ready(function() {
    $(document).on('click', '.buy-button', function() {
        const productId = $(this).data('id');
        const quantity = parseInt($(`#quantity-${productId}`).val());

        $.ajax({
            url: './Action/verificarStock.php',
            method: 'POST',
            data: {
                idProducto: productId,
                cantidad: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    handleCart(productId, quantity, response.stockDisponible);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error al verificar el stock.');
            }
        });
    });

    function handleCart(productId, quantity, stockDisponible) {
        const $card = $(`[data-id="${productId}"]`).closest('.card');
        const productName = $card.find('.card-title').text();
        const productDetail = $card.find('.card-text').eq(0).text();
        const productPrice = parseFloat($card.find('.fw-bold').text().replace('$', ''));
        const productImg = $card.find('img').attr('src');

        const product = {
            id: productId,
            nombre: productName,
            descripcion: productDetail,
            precio: productPrice,
            cantidad: quantity,
            img: productImg,
        };

        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        const existingIndex = carrito.findIndex(item => item.id === productId);

        if (existingIndex !== -1) {
            carrito[existingIndex].cantidad += quantity;

            if (carrito[existingIndex].cantidad > stockDisponible) {
                alert('Cantidad seleccionada excede el stock disponible.');
                carrito[existingIndex].cantidad = stockDisponible;
            } else {
                alert('Cantidad actualizada en el carrito.');
            }
        } else {
            carrito.push(product);
            alert('Producto agregado al carrito.');
        }

        localStorage.setItem('carrito', JSON.stringify(carrito));
    }
});