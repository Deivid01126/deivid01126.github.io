<?php
$conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "SELECT * FROM citas WHERE id = $id";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #07071e; /* Fondo oscuro */
                    color: #ffffff; /* Texto blanco */
                    margin: 0;
                    padding: 20px;
                }

                h2 {
                    color: #6f00ff; /* Texto morado neon */
                }

                form {
                    background-color: #1c1c42; /* Azul oscuro */
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #6f00ff; /* Texto morado neon */
                }

                input[type="text"],
                input[type="submit"],
                input[type="date"],
                input[type="time"],
                select {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 10px;
                    border: 1px solid #6f00ff; /* Borde morado neon */
                    border-radius: 5px;
                    background-color: #141433; /* Fondo oscuro */
                    color: #ffffff; /* Texto blanco */
                    box-shadow: 0 0 5px #6f00ff; /* Sombra morada neon */
                }

                input[type="submit"] {
                    background-color: #6f00ff; /* Morado neon */
                    color: #ffffff; /* Texto blanco */
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: #00ffea; /* Azul neon */
                }
            </style>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eliminar Producto</title>
        </head>
        <body>
        <div class="container">
            <h2>Confirmar Eliminacion de Cita</h2>
            <p>ID: <?php echo $row['id']; ?></p>
            <p>Cliente: <?php echo $row['cliente']; ?></p>
            <p>Mascota: <?php echo $row['mascota']; ?></p>
            <p>Fecha: <?php echo $row['fecha']; ?></p>
            <p>Hora: <?php echo $row['hora']; ?></p>
            <p>Servicio: <?php echo $row['servicio']; ?></p>
            <p>Observaciones: <?php echo $row['observaciones']; ?></p>

            <h3>¿Está seguro de que desea eliminar este producto?</h3>
            <form method="post" action="procesar_eliminar.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="submit" value="Eliminar">
            </form>
    </div>
        </body>

        </html>
<?php
    } else {
        echo "No se encontró ningún producto con el ID proporcionado.";
    }
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #07071e; /* Fondo oscuro */
                    color: #ffffff; /* Texto blanco */
                    margin: 0;
                    padding: 20px;
                }

                h2 {
                    color: #6f00ff; /* Texto morado neon */
                }

                form {
                    background-color: #1c1c42; /* Azul oscuro */
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #6f00ff; /* Texto morado neon */
                }

                input[type="text"],
                input[type="submit"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    background-color: #07071e; /* Fondo oscuro */
                    color: #ffffff; /* Texto blanco */
                    /* Estilos neon */
                    text-shadow: 0 0 10px #6f00ff, 0 0 20px #6f00ff, 0 0 30px #6f00ff, 0 0 40px #6f00ff, 0 0 70px #6f00ff, 0 0 80px #6f00ff, 0 0 100px #6f00ff, 0 0 150px #6f00ff;
                }

                input[type="submit"] {
                    background-color: #6f00ff; /* Morado neon */
                    color: #ffffff; /* Texto blanco */
                    cursor: pointer;
                    /* Estilos neon */
                    box-shadow: 0 0 10px #6f00ff, 0 0 20px #6f00ff, 0 0 30px #6f00ff, 0 0 40px #6f00ff, 0 0 70px #6f00ff, 0 0 80px #6f00ff, 0 0 100px #6f00ff, 0 0 150px #6f00ff;
                }

                input[type="submit"]:hover {
                    background-color: #00ffea; /* Azul neon */
                }
            </style>
</head>
<body>
    <div class="container">
        <h2>Eliminar Producto</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="id">ID del Producto:</label>
            <input type="text" name="id" id="id" required>
            <br>
            <input type="submit" value="Buscar">
        </form>
    </div>
</body>
</html>

<?php
}
?>
