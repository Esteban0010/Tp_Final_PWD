<?php
include_once '../../../configuracion.php';

session_start();

header('Content-Type: application/json'); // Asegura que el cliente reciba JSON

$datos = data_submitted();
$abmUsuario = new AbmUsuario();
$response = [];
echo "<script>console.log(" . json_encode($datos) . ");</script>";
try {
    // Procesa la actualización del usuario
    if (isset($datos['nombre'], $datos['mail'], $datos['password'])) {
        // Obtén el ID del usuario desde la sesión
        echo "<script>console.log(" . json_encode($datos['nombre']) . ");</script>";

        echo "<script>console.log(" . json_encode("hola") . ");</script>";

        if (!isset($datos['id'])) {
            throw new Exception('No se encontró un usuario en la sesión.');
        }

        // Actualiza los datos del usuario
        $actualizado = $abmUsuario->modificacion($datos);

        if ($actualizado) {
            $response = [
                'respuesta' => true,
                'mensaje' => 'Datos actualizados correctamente.',
                'redirect' => '../perfilUser.php?success=1'
            ];
        } else {
            throw new Exception('No se pudo actualizar el usuario. Verifica los datos ingresados.');
        }
    } else {
        throw new Exception('No se recibieron datos suficientes para la actualización.');
    }
} catch (Exception $e) {
    // Manejo de errores
    $response = [
        'respuesta' => false,
        'errorMsg' => $e->getMessage()
    ];
}

// Envía la respuesta como JSON
echo json_encode($response);
exit;
