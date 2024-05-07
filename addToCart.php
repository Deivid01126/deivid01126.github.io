<?php
session_start();

// Establecer conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "aguila011"; // La contraseña, si la tienes configurada
$dbname = "veterinaria";

// ID del producto
$id = $_GET['id'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener la cantidad disponible
$sql = "SELECT cantidad_disponible FROM alimentos WHERE id=$id";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cantidadDisponible = $row['cantidad_disponible'];
        if ($cantidadDisponible > 0) {
            // Reducir la cantidad disponible
            $cantidadDisponible--;

            // Actualizar la cantidad disponible en la base de datos
            $sql = "UPDATE alimentos SET cantidad_disponible=$cantidadDisponible WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                // Guardar en el carrito
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }
                array_push($_SESSION['cart'], $id);
                echo "success";
            } else {
                echo "Error al actualizar la cantidad disponible: " . $conn->error;
            }
        } else {
            echo "no_disponible";
        }
    } else {
        echo "No se encontraron resultados para el ID proporcionado.";
    }
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
