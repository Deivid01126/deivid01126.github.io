<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Ventas de Alimentos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #07071e; /* Fondo negro */
            color: #ffffff; /* Texto blanco */
            overflow-x: hidden;
        }

        .container {
            padding: 50px 0;
            text-align: center;
        }

        .grafica-tarjeta {
            margin-bottom: 20px;
        }

        .form-label {
            color: #ffffff; /* Texto blanco */
        }
    </style>
</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "aguila011", "veterinaria");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql_alimentos = "SELECT * FROM alimentos";
$result_alimentos = $conn->query($sql_alimentos);
$productos = [];
$cantidad = [];
while ($row = $result_alimentos->fetch_assoc()) {
    $productos[] = $row['nombre'];
    $cantidad[] = $row['cantidad_disponible'];
}

$conn->close();
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card grafica-tarjeta">
                <div class="card-body">
                    <h5 class="card-title">Distribución de Almacén de Alimentos</h5>
                    <canvas id="graficoMasVendidos"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card grafica-tarjeta">
                <div class="card-body">
                    <h5 class="card-title">Distribución de Almacén de Alimentos (Pastel)</h5>
                    <canvas id="graficoPastelMasVendidos"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var ctxMasVendidos = document.getElementById('graficoMasVendidos').getContext('2d');
var graficoMasVendidos = new Chart(ctxMasVendidos, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($productos); ?>,
        datasets: [{
            label: 'Cantidad Disponible',
            data: <?php echo json_encode($cantidad); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

var ctxPastelMasVendidos = document.getElementById('graficoPastelMasVendidos').getContext('2d');
var graficoPastelMasVendidos = new Chart(ctxPastelMasVendidos, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($productos); ?>,
        datasets: [{
            data: <?php echo json_encode($cantidad); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ]
        }]
    }
});
</script>
</body>
</html>
