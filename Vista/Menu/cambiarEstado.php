<?php
include_once('../../configuracion.php');
header('Content-Type: application/json');

$datos = data_submitted();
$response = ['success' => false, 'mensaje' => '', 'fechaFin' => null];

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
        if (($estadoActual == 1 && in_array($nuevoEstado, [2, 4])) ||
            ($estadoActual == 2 && $nuevoEstado == 3) ||
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