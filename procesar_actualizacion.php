<?php
$conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nuevo_servicio = $_POST['nuevo_servicio'];
    $nueva_fecha = $_POST['nueva_fecha'];
    $nueva_hora = $_POST['nueva_hora'];

    // Preparar la consulta SQL para actualizar la cita
    $sql = "UPDATE citas SET servicio = '$nuevo_servicio', fecha = '$nueva_fecha', hora = '$nueva_hora' WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        echo "Cita actualizada correctamente.";
    } else {
        echo "Error al actualizar la cita: " . $conexion->error;
    }
} else {
    echo "Error: No se recibió ningún dato del formulario.";
}

$conexion->close();
?>
