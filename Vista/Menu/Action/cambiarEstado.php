<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once('../../../configuracion.php');
header('Content-Type: application/json');

require "../../../vendor/autoload.php";

$datos = data_submitted();
$response = ['success' => false, 'mensaje' => '', 'fechaFin' => null];
//php mailer
function enviarCorreoEstadoCompra($compra, $nuevoEstado) {
    $mail = new PHPMailer(true);

    try {
    
        // Mapear estados a mensajes
        $estadosMensajes = [
            2 => 'Aceptada',
            3 => 'Enviada',
            4 => 'Cancelada'
        ];

        $asunto = "Estado de tu compra #" . $compra->getObjCompra()->getIdCompra();
        $mensaje = "Estimado/a Cliente,\n\n";
        $mensaje .= "El estado de tu compra #{$compra->getObjCompra()->getIdCompra()} ha sido actualizado a: {$estadosMensajes[$nuevoEstado]}.\n";
        
        // Configuración SMTP 
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'martin.paredes@est.fi.uncoma.edu.ar';
        $mail->Password   = 'xfbayouwwbfuzrgc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Configurar correo
        $mail->setFrom('martin.paredes@est.fi.uncoma.edu.ar', 'TP_FINAL_PWD');
        $mail->addAddress('mdep171@gmail.com','Martin Paredes');
        $mail->addAddress('fran.canoeslalom@gmail.com','Francisco Pandolfi');
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = nl2br($mensaje);

        // Enviar correo
        $mail->send();
        
        return true;
    } catch (Exception $e) {
        // Opcional: loguear el error
        error_log("Error enviando correo: " . $mail->ErrorInfo);
        return false;
    }
}

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
                    $envioCorreo = enviarCorreoEstadoCompra($compraEstado, $nuevoEstado);
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