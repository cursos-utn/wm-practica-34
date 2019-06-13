<?php
$usuario = $_POST['usuario'];
$password = $_POST['password'];

require "config.php";

$conexion = mysqli_connect(DB_SERVIDOR, DB_USER, DB_PASSWORD, DB_BASE) or die("No me pude conectar con la base de datos");

$sql = "select * from usuario where usuario='$usuario'";


$respuesta_query = mysqli_query($conexion, $sql);

$registro = mysqli_fetch_array($respuesta_query);

if (!$registro) {
    echo "Usuario incorrecto";
    die();
}

// El usuario es correcto, ahora tengo que verificar la contraseña
$password_en_bd = $registro['password'];
if (password_verify($password, $password_en_bd) == false) {
    echo "Contraseña incorrecta";
    die();
}

// Si llego hasta aca es porque es valido el usuario/password
session_start();
$_SESSION['usuario_id'] = $registro['id'];
// Aca se puede mostrar una pagina o redirigir a la pagina principal
header("Location: segura.php");

?>
