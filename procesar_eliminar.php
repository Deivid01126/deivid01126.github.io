<?php
$conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM citas WHERE id = $id";
    if ($conexion->query($sql) === TRUE) {
        echo "El producto ha sido eliminado exitosamente.";
    } else {
        echo "Error al intentar eliminar el producto: " . $conexion->error;
    }
}
?>
