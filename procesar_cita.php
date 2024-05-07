<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Cita Veterinario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #07071e; 
            color: #fff; 
            overflow-x: hidden;
            padding: 20px; 
        }

        label {
            color: #fff; 
        }

        .container {
            max-width: 600px; 
            margin: auto; 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cliente = $_POST["nombre"];
            $mascota = $_POST["mascota"];
            $fecha = $_POST["fecha"];
            $hora = $_POST["hora"];
            $servicio = $_POST["servicio"];
            $observaciones = $_POST["observaciones"];

            $conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $query = "INSERT INTO citas (cliente, mascota, fecha, hora, servicio, observaciones) VALUES ('$cliente', '$mascota', '$fecha', '$hora', '$servicio', '$observaciones')";

            if ($conexion->query($query) === TRUE) {
                echo "<h2>Cita Agendada Exitosamente</h2>";
                echo "<p>Los detalles de la cita han sido registrados en la base de datos.</p>";
            } else {
                echo "<h2>Error al Agendar la Cita</h2>";
                echo "<p>Error al ejecutar la consulta: " . $conexion->error . "</p>";
            }

            $conexion->close();
        } else {
            echo "<h2>Error</h2>";
            echo "<p>No se han recibido datos para procesar.</p>";
        }
        ?>
    </div>
</body>
</html>
