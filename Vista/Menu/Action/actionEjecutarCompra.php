<?php
include_once("../../../configuracion.php");
require('../../Asets/librerias/fpdf/fpdf.php'); // Verificar la ruta a FPDF

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carrito = isset($_POST['carrito']) ? json_decode($_POST['carrito'], true) : [];

    if (empty($carrito)) {
        $response['message'] = 'El carrito está vacío.';
        echo json_encode($response);
        exit;
    }

    try {
        $abmCompra = new AbmCompra();
        $session = new Session();
        $objUsuario = $session->getUsuario();

        $nuevaCompra = [
            'productos' => $carrito,
            'cofecha' => date('Y-m-d H:i:s'),
            'usuario_id' => $objUsuario->getId()
        ];

        $resultado = $abmCompra->alta($nuevaCompra);

        if ($resultado) {
            // Crear directorio si no existe
            $directory = '../../Asets/pdf';
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            chmod($directory, 0777);

            // Generar PDF
            try {
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(190, 10, 'Boleta de Compra', 0, 1, 'C');
                $pdf->Ln(10);
            
                // Información del usuario
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(40, 10, 'Usuario: ' . ($objUsuario ? $objUsuario->getNombre() : 'Desconocido'));
                $pdf->Ln(8);
                $pdf->Cell(40, 10, 'Fecha: ' . date('Y-m-d H:i:s'));
                $pdf->Ln(10);
            
                // Encabezado de tabla
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(80, 10, 'Producto', 1);
                $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
                $pdf->Cell(30, 10, 'Precio', 1, 0, 'R');
                $pdf->Cell(50, 10, 'Subtotal', 1, 0, 'R');
                $pdf->Ln();
            
                // Detalles del carrito
                $total = 0;
                foreach ($carrito as $producto) {
                    $nombre = $producto['nombre'] ?? 'Producto sin nombre';
                    $cantidad = $producto['cantidad'] ?? 0;
                    $precio = $producto['precio'] ?? 0;
                    $subtotal = $cantidad * $precio;
                    $total += $subtotal;
            
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(80, 10, $nombre, 1);
                    $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
                    $pdf->Cell(30, 10, '$' . number_format($precio, 2), 1, 0, 'R');
                    $pdf->Cell(50, 10, '$' . number_format($subtotal, 2), 1, 0, 'R');
                    $pdf->Ln();
                }
            
                // Total
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(140, 10, 'Total', 1);
                $pdf->Cell(50, 10, '$' . number_format($total, 2), 1, 0, 'R');
            
                // Guardar PDF en una ruta específica
                $filePath = '../../Asets/pdf/boleta_compra_' . time() . '.pdf';
                $pdf->Output('F', $filePath);
            

                $response['success'] = true;
            } catch (Exception $e) {
                $response['message'] = 'Error al generar el PDF: ' . $e->getMessage();
                error_log('Error al generar el PDF: ' . $e->getMessage());
            }
        } else {
            $response['message'] = 'No se pudo procesar la compra.';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
        error_log($e->getMessage());
    }
}

echo json_encode($response);
?>
