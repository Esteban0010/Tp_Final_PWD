<?php
session_start();
require_once 'AbmUsuario.php';

// Obtener los datos enviados
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

// Actualizar los datos en la base de datos
$abmUsuario = new AbmUsuario();
$idUsuario = $_SESSION['idusuario'];

$parametros = [
    'idusuario' => $idUsuario,
    'nombre' => $nombre,
    'apellido' => $apellido,
    'email' => $email,
];

if ($password) {
    $parametros['password'] = $password;
}



$abmUsuario->modificar($parametros);

header('Location: miperfil.php?success=1');
