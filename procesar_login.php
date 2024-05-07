<?php
// procesar_login.php

$conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");
        
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql_usuarios = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
$result_usuarios = $conexion->query($sql_usuarios);

if ($result_usuarios->num_rows > 0) {
    $row = $result_usuarios->fetch_assoc();
    $nivel = $row['nivel'];
    
    switch ($nivel) {
        case 1:
            header("Location: home.php");
            break;
        case 2:
            header("Location: home2.html");
            break;
        case 3:
            header("Location: home3.html");
            break;
        default:
            echo "Nivel de usuario no válido.";
            break;
    }
} else {
    echo "Inicio de sesión fallido. Verifique sus credenciales.";
}

$conexion->close();
?>
