<?php
require_once 'conexion.php';
$connection = Conectarse();

$pass = '';
$new_pass = password_hash($pass, PASSWORD_BCRYPT);

$email = 'nuevo_correo@ejemplo.com';
$name = '';
$reset = 0;
$token = '';

$insertPasswordQuery = "INSERT INTO UsuariosSicah (CORREO, CONTRASENA, RESET, TOKEN, NOMBRE) VALUES (:email, :new_pass, :reset, :token, :name);";

$statement = $connection->prepare($insertPasswordQuery);
$statement->bindParam(':email', $email);
$statement->bindParam(':name', $name);
$statement->bindParam(':new_pass', $new_pass, PDO::PARAM_STR);
$statement->bindParam(':reset', $reset, PDO::PARAM_INT);
$statement->bindParam(':token', $token, PDO::PARAM_STR);

if ($statement->execute()) {
    echo 'Usuario creado con Exito';
} else {
    echo 'error';
}
?>