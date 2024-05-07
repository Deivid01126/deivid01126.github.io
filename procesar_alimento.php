<?php
if (isset($_POST['nombre']) && isset($_POST['tipo']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $marca = isset($_POST['marca']) ? mysqli_real_escape_string($conexion, $_POST['marca']) : null;
    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    $consulta = "INSERT INTO alimentos (nombre, marca, tipo, precio, cantidad_disponible) VALUES ('$nombre', '$marca', '$tipo', $precio, $cantidad)";

    if (mysqli_query($conexion, $consulta)) {
        echo "Alta exitosa: " . mysqli_error($conexion);
        exit();
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    header("Location: error.php");
    exit();
}
?>
