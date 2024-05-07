<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Veterinaria Amigo Fiel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #07071e; /* Fondo negro */
            color: #fff; /* Texto blanco */
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        #logo {
            text-align: center;
            margin-bottom: 30px;
        }

        #logo img {
            max-width: 300px;
            height: auto;
        }

        #mensaje-bienvenida {
            text-align: center;
            margin-bottom: 30px;
        }

        #mensaje-bienvenida h2 {
            color: #6f00ff; /* Morado Neon */
            margin-bottom: 20px;
        }

        #mensaje-bienvenida p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #121212;
            border: none;
            color: #fff;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="logo">
            <img src="Imagenes/logo.jpeg" alt="Logo de Clínica Veterinaria Amigo Fiel">
        </div>
        
        <div id="mensaje-bienvenida">
            <h2>Bienvenido a la Clínica Veterinaria Amigo Fiel</h2>
            <p>Su mejor opción para el cuidado de sus mascotas. En nuestra clínica, nos dedicamos a brindar servicios veterinarios de alta calidad para asegurar la salud y felicidad de sus queridos animales. Nuestro equipo de veterinarios altamente calificados está aquí para ayudar a sus mascotas en cada paso del camino.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="Imagenes/servicio1.jpeg" class="card-img-top" alt="Servicio 1">
                    <div class="card-body">
                        <h5 class="card-title">Consulta Veterinaria</h5>
                        <p class="card-text">Ofrecemos consultas veterinarias completas para diagnosticar y tratar cualquier problema de salud que puedan tener sus mascotas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Imagenes/servicio2.jpeg" class="card-img-top" alt="Servicio 2">
                    <div class="card-body">
                        <h5 class="card-title">Cirugías</h5>
                        <p class="card-text">Realizamos cirugías veterinarias especializadas con el máximo cuidado y atención para garantizar la seguridad y el bienestar de sus mascotas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="Imagenes/servicio3.jpeg" class="card-img-top" alt="Servicio 3">
                    <div class="card-body">
                        <h5 class="card-title">Vacunación</h5>
                        <p class="card-text">Proporcionamos servicios completos de vacunación para prevenir enfermedades y mantener a sus mascotas saludables y felices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
