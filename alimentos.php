<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Alimentos</title>
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
        input[type="number"],
        select {
            background-color: #141433; /* Color de fondo más oscuro */
            color: #fff; /* Color de texto blanco */
            border: none; /* Borde ninguno */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px; /* Añadido para mejorar el espaciado */
            margin-bottom: 10px; /* Añadido para mejorar el espaciado */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
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
        <h1>Alta de Alimentos</h1>
        <form action="procesar_alimento.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Alimento:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca">
            </div>
            <div class="form-group">
                <label for="tipo">Tipo de Mascota:</label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="">Seleccionar</option>
                    <option value="Gatos">Gatos</option>
                    <option value="Conejos">Conejos</option>
                    <option value="Perros">Perros</option>
                    <option value="Tortugas">Tortugas</option>
                    <option value="Hamsters">Hamsters</option>
                    <option value="Pájaros">Pájaros</option>
                    <option value="Peces">Peces</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad Disponible:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>
