<?php
include_once '../../../configuracion.php';

session_start();

header('Content-Type: application/json'); // Asegura que el cliente reciba JSON

$datos = data_submitted();
$abmUsuario = new AbmUsuario();
$response = [];
// echo "<script>console.log(" . json_encode($datos) . ");</script>";
try {
    // Procesa la actualización del usuario
    if (isset($datos['nombre'], $datos['mail'], $datos['password'])) {
        // Obtén el ID del usuario desde la sesión


        if (!isset($datos['id'])) {
            throw new Exception('No se encontró un usuario en la sesión.');
        }

        $parametros = [
            'idusuario' => $datos['id'],
            'usnombre' => $datos['nombre'],
            'usmail' => $datos['mail'],
            'uspass' =>  $datos['password'],
            'usdeshabilitado' => null,
        ];
        // echo "<script>console.log(" . json_encode("no pasaS") . ");</script>";
        // Actualiza los datos del usuario

        if ($abmUsuario->modificacion($parametros)) {
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
ob_clean();
// Envía la respuesta como JSON
echo json_encode($response);
exit;