<?php
include_once("../../../configuracion.php");

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del carrito
    $carrito = isset($_POST['carrito']) ? json_decode($_POST['carrito'], true) : [];

    if (empty($carrito)) {
        $response['message'] = 'El carrito está vacío.';
        echo json_encode($response);
        exit;
    }

    try {
        // Crear instancia de AbmCompra
        $abmCompra = new AbmCompra();

        // Crear una nueva compra
        $nuevaCompra = [
            'productos' => $carrito, // Lista de productos con cantidades
            'fecha' => date('Y-m-d H:i:s'), // Fecha actual
            'usuario_id' => 1 // ID del usuario (puede ser dinámico si hay sesión)
        ];

        $resultado = $abmCompra->alta($nuevaCompra);

        if ($resultado) {
            $response['success'] = true;
        } else {
            $response['message'] = 'No se pudo procesar la compra.';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>