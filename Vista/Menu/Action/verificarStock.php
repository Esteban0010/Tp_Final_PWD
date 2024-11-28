<?php
include_once("../../../configuracion.php");

// Recuperar los datos usando la función data_submitted
$data = data_submitted();

// Asegurar que los datos críticos sean enteros
$data['idProducto'] = isset($data['idProducto']) ? (int)$data['idProducto'] : 0;
$data['cantidad'] = isset($data['cantidad']) ? (int)$data['cantidad'] : 0;

// Inicializar respuesta por defecto
$retorno = ['success' => false, 'message' => ''];

// Validar los datos recibidos
if ($data['idProducto'] > 0 && $data['cantidad'] > 0) {
    // Instanciamos el objeto de control de productos
    $objControl = new AbmProducto();
    
    // Buscar el producto por ID
    $producto = $objControl->buscar(['idproducto' => $data['idProducto']]);

    if (!empty($producto)) {
        $stockActual = $producto[0]->getProCantStock();

        // Validar si la cantidad solicitada está disponible
        if ($data['cantidad'] <= $stockActual) {
            $retorno['success'] = true;
            $retorno['message'] = 'Stock disponible.';
        } else {
            $retorno['message'] = 'No hay suficiente stock.';
        }
    } else {
        $retorno['message'] = 'Producto no encontrado.';
    }
} else {
    $retorno['message'] = 'No hay suficiente stock.';
}

// Devolver la respuesta como JSON
echo json_encode($retorno);
?>


