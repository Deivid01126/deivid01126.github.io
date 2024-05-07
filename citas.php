<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita Veterinario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #07071e; /* Fondo negro */
            color: #fff; /* Texto blanco */
            overflow-x: hidden;
            padding: 20px; /* Añadido para mejorar el espaciado */
        }

        label {
            color: #fff; /* Color de texto blanco */
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            background-color: #141433; /* Color de fondo más oscuro */
            color: #fff; /* Color de texto blanco */
            border: none; /* Borde ninguno */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px; /* Añadido para mejorar el espaciado */
            margin-bottom: 10px; /* Añadido para mejorar el espaciado */
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        select:focus,
        textarea:focus {
            outline: none; /* Quita el contorno en enfoque */
            box-shadow: 0 0 5px #6f00ff; /* Sombra al enfocar */
        }

        .btn-primary {
            background-color: #6f00ff; /* Morado Neon */
            border-color: #6f00ff; /* Borde Morado Neon */
            color: #fff; /* Texto blanco */
            padding: 10px 20px; /* Añadido para mejorar el espaciado */
            border-radius: 5px; /* Bordes redondeados */
            transition: background-color 0.3s, border-color 0.3s; /* Transición suave */
        }

        .btn-primary:hover {
            background-color: #00ffea; /* Azul Neon */
            border-color: #00ffea; /* Borde Azul Neon */
        }

        .container {
            max-width: 600px; /* Ancho máximo del contenedor */
            margin: auto; /* Centrar el contenedor */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agendar Cita Veterinario</h1>
        <form action="procesar_cita.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="mascota">Nombre de la Mascota:</label>
                <input type="text" class="form-control" id="mascota" name="mascota" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha de la Cita:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora de la Cita:</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <div class="form-group">
                <label for="servicio">Tipo de Servicio:</label>
                <select class="form-control" id="servicio" name="servicio" required>
                    <option value="">Seleccionar</option>
                    <?php
                        $conexion = new mysqli("localhost", "root", "aguila011", "veterinaria");
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }

                        $query = "SELECT servicio_id, nombre FROM servicios";
                        $result = $conexion->query($query);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay servicios disponibles</option>";
                        }
                        $conexion->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var fechaInput = document.getElementById("fecha");
            fechaInput.addEventListener("input", function() {
                var fechaSeleccionada = new Date(this.value);
                if (fechaSeleccionada.getDay() === 5 || fechaSeleccionada.getDay() === 6) {
                    alert("Por favor, seleccione un día entre semana (lunes a viernes).");
                    this.value = "";
                }
            });
            
            var horaInput = document.getElementById("hora");
            horaInput.addEventListener("input", function() {
                var horaSeleccionada = this.value;
                var hora = parseInt(horaSeleccionada.split(":")[0]);
                var minutos = parseInt(horaSeleccionada.split(":")[1]);
                var periodo = horaSeleccionada.slice(-2);
                
                if ((periodo === "AM" && (hora < 9 || hora === 12)) || (periodo === "PM" && (hora > 6 || hora === 12))) {
                    alert("Por favor, seleccione una hora entre las 9:00 AM y las 6:00 PM.");
                    this.value = "";
                }
            });
        });
    </script>
</body>
</html>
