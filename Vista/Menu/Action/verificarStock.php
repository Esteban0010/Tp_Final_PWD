
<?php
include_once("../../../configuracion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperamos el ID del producto y la cantidad deseada
    $idProducto = isset($_POST['idProducto']) ? (int)$_POST['idProducto'] : 0;
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

    if ($idProducto > 0 && $cantidad > 0) {
        // Instanciamos el objeto de control de productos
        $objControl = new AbmProducto();
        // Buscamos el producto por ID
        $producto = $objControl->buscar(['idproducto' => $idProducto]);

        // Si encontramos el producto
        if (!empty($producto)) {
            $stockActual = $producto[0]->getProCantStock();

            // Verificamos si la cantidad solicitada es menor o igual al stock
            if ($cantidad <= $stockActual) {
                echo json_encode(['success' => true, 'message' => 'Stock disponible.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No hay suficiente stock.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay Stock.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>

