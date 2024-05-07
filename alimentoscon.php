<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Productos </title>
    <style>
        body {
            font-family: "Trebuchet MS", Arial, sans-serif;
            background-color: #07071e; /* Fondo oscuro */
            margin: 0;
            padding: 0;
            color: #ffffff; /* Texto blanco */
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #1c1c42; /* Azul oscuro */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #ff00ff; /* Texto morado neon */
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-weight: bold;
            color: #ff00ff; /* Texto morado neon */
        }
        select, input[type="text"], button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ff00ff; /* Borde morado neon */
            border-radius: 4px;
            font-size: 16px;
            background-color: #07071e; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco */
        }
        button {
            background-color: #ff00ff; /* Morado neon */
            color: #ffffff; /* Texto blanco */
            cursor: pointer;
        }
        button:hover {
            background-color: #00ffea; /* Azul neon */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ff00ff; /* Borde morado neon */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #6f00ff; /* Morado neon */
            color: #ffffff; /* Texto blanco */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consulta de Productos</h1>

        <form method="post">
            <label for="consulta">Selecciona una consulta:</label>
            <select name="consulta" id="consulta">
                <option value="general">General</option>
                <option value="id">Por ID</option>
                <option value="promedio_cantidad">Promedio sobre Costo</option>
                <option value="ascendente">Ascendente sobre Mascota</option>
                <option value="descendente">Descendente sobre Mascota</option>
                <option value="maximo_minimo_cantidad">Máximo y Mínimo sobre Costo</option>
            </select>
            <input type="text" name="id" placeholder="ID del Producto">
            <button type="submit">Consultar</button>
        </form>

        <?php
        $conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $consulta = $_POST["consulta"];
            switch ($consulta) {
                case "general":
                    $resultado = $conexion->query("SELECT * FROM alimentos");
                    break;
                case "id":
                    $id = $_POST["id"];
                    $stmt = $conexion->prepare("SELECT * FROM alimentos WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    break;
                case "promedio_cantidad":
                    $sql = "SELECT AVG(precio) AS promedio_cantidad FROM alimentos";
                    $resultado_promedio = $conexion->query($sql);
                    if ($resultado_promedio) {
                        $fila_promedio = $resultado_promedio->fetch_assoc();
                        echo "<h2>Promedio sobre Costo</h2>";
                        echo "<p>Promedio de precio: " . $fila_promedio["promedio_cantidad"] . "</p>";
                    } else {
                        echo "No se pudo calcular el promedio.";
                    }
                    break;
                case "ascendente":
                    $sql = "SELECT * FROM alimentos ORDER BY marca ASC";
                    $resultado = $conexion->query($sql);
                    break;
                case "descendente":
                    $sql = "SELECT * FROM alimentos ORDER BY marca DESC";
                    $resultado = $conexion->query($sql);
                    break;
                    case "maximo_minimo_cantidad":
                    $sql_maximo_minimo = "SELECT MAX(precio) AS maximo_cantidad, MIN(precio) AS minimo_cantidad FROM alimentos";
                    $resultado_maximo_minimo = $conexion->query($sql_maximo_minimo);
                    if ($resultado_maximo_minimo) {
                        $fila_maximo_minimo = $resultado_maximo_minimo->fetch_assoc();
                        echo "<h2>Máximo y Mínimo sobre Cantidad</h2>";
                        echo "<p>Máximo de precio: " . $fila_maximo_minimo["maximo_cantidad"] . "</p>";
                        echo "<p>Mínimo de precio: " . $fila_maximo_minimo["minimo_cantidad"] . "</p>";
                    } else {
                        echo "No se encontraron citas.";
                    }
                    break;
                default:
                    $sql = "SELECT * FROM alimentos";
            }
            if (isset($resultado) && $resultado->num_rows > 0) {
                echo "<h2>Consulta Específica</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Marca</th><th>Tipo</th><th>Precio</th><th>Cantidad Disponible</th></tr>";
                while($fila = $resultado->fetch_assoc()) {
                    echo "<tr><td>".$fila["id"]."</td><td>".$fila["nombre"]."</td><td>".$fila["marca"]."</td><td>".$fila["tipo"]."</td><td>".$fila["precio"]."</td><td>".$fila["cantidad_disponible"]."</td></tr>";
                }
                echo "</table>";
            } elseif ($consulta == "id") {
                if ($resultado->num_rows == 0) {
                    echo "No se encontró ningún producto con el ID proporcionado.";
                }
            }

        }

        $conexion->close();
        ?>
    </div>
</body>
</html>
