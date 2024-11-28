<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once('../../../configuracion.php');
header('Content-Type: application/json');

require "../../../vendor/autoload.php";

$datos = data_submitted();
$response = ['success' => false, 'mensaje' => '', 'fechaFin' => null];
//php mailer


if (!empty($datos['idCompraEstado']) && !empty($datos['estado'])) {
    $idCompraEstado = $datos['idCompraEstado'];
    $nuevoEstado = $datos['estado'];
    $abmCompraEstado = new AbmCompraEstado();
    
    // Buscar el estado actual de la compra
    $compraEstadoActual = $abmCompraEstado->buscar(['idcompraestado' => $idCompraEstado]);
    
    if (!empty($compraEstadoActual)) {
        $compraEstado = $compraEstadoActual[0];
        $estadoActual = $compraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $idCompra = $compraEstado->getObjCompra()->getIdCompra();
        
        // Verificar si la transición de estado es válida
        $transicionValida = false;
        // Si el estado actual es '1' y el nuevo estado es '2' o '4'
        if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) ||
         // Si el estado actual es '2' y el nuevo estado es '3' 
            ($estadoActual == 2 && $nuevoEstado == 3) ||
              // Si el nuevo estado es '4', independientemente del estado actual 
            ($nuevoEstado == 4)) {
            $transicionValida = true;
        }
        
        if ($transicionValida) {
            $fechaActual = date('Y-m-d H:i:s');
            
            // 1. Cerrar el estado actual estableciendo la fecha fin
            $compraEstado->setCeFechaFin($fechaActual);
            $exito = $compraEstado->modificar();
            
            if ($exito) {
                // 2. Crear nuevo registro con el nuevo estado
                //$compraEstado->getObjCompra()->getIdCompra();
                $nuevoCompraEstado = new CompraEstado();
                $nuevoCompraEstado->setObjCompra($compraEstado->getObjCompra());
                
                $nuevoTipoEstado = new CompraEstadoTipo();
                $nuevoTipoEstado->setIdCompraEstadoTipo($nuevoEstado);
                $nuevoCompraEstado->setObjCompraEstadoTipo($nuevoTipoEstado);
                
                $nuevoCompraEstado->setCeFechaIni($fechaActual);
                $nuevoCompraEstado->setCeFechaFin(null);
                
                if ($nuevoCompraEstado->insertar()) {
                    $compra = new AbmCompraEstado();
                    $envioCorreo =  $compra->enviarCorreoEstadoCompra($compraEstado, $nuevoEstado);
                    $response = [
                        'success' => true,
                        'mensaje' => 'Estado actualizado correctamente',
                        
                        'fechaFin' => $fechaActual
                    ];
                    
                } else {
                    $response['mensaje'] = 'Error al crear el nuevo estado';
                }
            } else {
                $response['mensaje'] = 'Error al actualizar el estado actual';
            }
        } else {
            $response['mensaje'] = 'Transición de estado no válida';
        }
    } else {
        $response['mensaje'] = 'Estado de compra no encontrado';
    }
} else {
    $response['mensaje'] = 'Datos incompletos';
}

echo json_encode($response);
?>