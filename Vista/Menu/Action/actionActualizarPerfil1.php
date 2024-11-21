<?php
include_once '../../../configuracion.php';

// session_start();

// header('Content-Type: application/json'); // Asegura que el cliente reciba JSON

$datos = data_submitted(); //datos que actualizan USUARIO
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

        if (!empty($datos['nuevaPassword'])) {
            $contrasenia = $datos['nuevaPassword']; // Usar la nueva contraseña si se proporciona
        } else {
            $contrasenia = $datos['password']; // Mantener la contraseña actual si no se modifica
        }


        $parametros = [
            'idusuario' => $datos['id'],
            'usnombre' => $datos['nombre'],
            'usmail' => $datos['mail'],
            'uspass' =>  md5($contrasenia),
            'usdeshabilitado' => "null",
        ];
        // echo "<script>console.log(" . json_encode("no pasaS") . ");</script>";
        // Actualiza los datos del usuario

        if ($abmUsuario->modificacion($parametros)) {
            $response = [
                'respuesta' => true,
                'redirect' => '../perfilUser.php?success=1'
            ];
        }
    }
} catch (Exception $e) {
    // Manejo de errores
    $response = [

        'respuesta' => false,
    ];
}
ob_clean();
// Envía la respuesta como JSON
echo json_encode($response);
exit;
