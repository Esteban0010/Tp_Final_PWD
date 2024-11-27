<?php
include_once("../../../configuracion.php");
require('../../Asets/librerias/fpdf/fpdf.php');

$response = ['success' => false, 'message' => ''];

try {
    $datos = data_submitted();
    $carrito = isset($datos['carrito']) ? json_decode($datos['carrito'], true) : [];

    if (empty($carrito)) {
        throw new Exception('El carrito está vacío.');
    }

    foreach ($carrito as $producto) {
        if (!isset($producto['nombre'], $producto['cantidad'], $producto['precio']) || 
            !is_numeric($producto['cantidad']) || !is_numeric($producto['precio'])) {
            throw new Exception('Datos del carrito inválidos.');
        }
    }

    $session = new Session();
    $objUsuario = $session->getUsuario();
    if (!$objUsuario || !$objUsuario->getId()) {
        throw new Exception('Usuario no autenticado.');
    }

    $abmCompra = new AbmCompra();
    $nuevaCompra = [
        'productos' => $carrito,
        'cofecha' => date('Y-m-d H:i:s'),
        'usuario_id' => $objUsuario->getId()
    ];

    if (!$abmCompra->alta($nuevaCompra)) {
        throw new Exception('No se pudo procesar la compra.');
    }

    $directory = __DIR__ . '/../../Asets/pdf';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $filePath = $directory . '/boleta_compra_' . time() . '.pdf';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Boleta de Compra', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Usuario: ' . $objUsuario->getNombre());
    $pdf->Ln(8);
    $pdf->Cell(40, 10, 'Fecha: ' . date('Y-m-d H:i:s'));
    $pdf->Ln(10);
    $total = 0;
    foreach ($carrito as $producto) {
        $subtotal = $producto['cantidad'] * $producto['precio'];
        $total += $subtotal;
        $pdf->Cell(80, 10, $producto['nombre'], 1);
        $pdf->Cell(30, 10, $producto['cantidad'], 1, 0, 'C');
        $pdf->Cell(30, 10, '$' . number_format($producto['precio'], 2), 1, 0, 'R');
        $pdf->Cell(50, 10, '$' . number_format($subtotal, 2), 1, 0, 'R');
        $pdf->Ln();
    }
    $pdf->Cell(140, 10, 'Total', 1);
    $pdf->Cell(50, 10, '$' . number_format($total, 2), 1, 0, 'R');
    $pdf->Output('F', $filePath);

    $response = [
        'success' => true,
        'message' => 'Compra procesada correctamente.',
        'filePath' => $filePath
    ];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log($e->getMessage());
}

echo json_encode($response);
