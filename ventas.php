<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentos para Mascotas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #fff;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border: 1px solid #00f3ff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }
        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #00f3ff;
            color: #000;
        }
        .add-to-cart {
            background-color: #000;
            border: 2px solid #00f3ff;
            color: white;
            padding: 8px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;
        }
        .add-to-cart:hover {
            background-color: #00d5e0;
        }
        .checkout-btn {
            background-color: #000;
            border: 2px solid #00f3ff;
            color: white;
            padding: 8px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;
            float: right;
        }
        .checkout-btn:hover {
            background-color: #00d5e0;
        }
        .cart {
            float: right;
            margin-top: 20px;
            margin-right: 10px;
        }
        .cart span {
            background-color: #4caf50;
            color: white;
            padding: 5px 10px;
            border-radius: 50%;
        }
        .input-box {
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 2px solid #00f3ff;
            background-color: transparent;
            color: #fff;
        }

        .input-box input:focus {
            outline: none;
            border-color: #00f3ff;
        }

        .boton {
            background-color: #00f3ff;
            color: #000;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .boton:hover {
            background-color: #00d5e0;
        }

        /* Estilos para el "CAPTCHA" */
        .captcha-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            align-items: center;
        }

        .captcha-checkbox {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Alimentos para Mascotas</h1>
        <div class="cart">Carrito <span id="cart-count"><?php echo (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0; ?></span></div>
    </header>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Cantidad Disponible</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                    // Establecer conexión con la base de datos
                    $servername = "localhost";
                    $username = "root";
                    $password = "aguila011"; // La contraseña, si la tienes configurada
                    $dbname = "veterinaria";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Comprobar la conexión
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Consulta SQL para obtener los datos de la tabla 'alimentos'
                    $sql = "SELECT * FROM alimentos";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Imprimir datos de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>". $row["id"]. "</td>
                                <td>". $row["nombre"]. "</td>
                                <td>". $row["marca"]. "</td>
                                <td>". $row["tipo"]. "</td>
                                <td>$". number_format($row["precio"], 2). "</td>
                                <td id='cantidad-disponible-" . $row["id"] . "'>". $row["cantidad_disponible"]. "</td>
                                <td><button class='add-to-cart' onclick='addToCart(" . $row["id"] . ")'>Añadir al carrito</button></td>
                            </tr>";
                        }
                    } else {
                        echo "0 resultados";
                    }

                    // Cerrar la conexión
                    $conn->close();
                ?>
            </tbody>
        </table>
        <a href="checkout.php" class="checkout-btn">Realizar Pago</a>
    </div>

    <script>
        function addToCart(id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "success") {
                        var cantidadDisponible = document.getElementById('cantidad-disponible-' + id);
                        cantidadDisponible.innerHTML = parseInt(cantidadDisponible.innerHTML) - 1;
                        var cartCount = document.getElementById('cart-count');
                        cartCount.innerHTML = parseInt(cartCount.innerHTML) + 1;
                        alert("Producto añadido al carrito.");
                    } else if (this.responseText == "no_disponible") {
                        alert("No hay suficiente cantidad disponible.");
                    } else {
                        alert("Error al añadir al carrito: " + this.responseText);
                    }
                }
            };
            xmlhttp.open("GET", "addToCart.php?id=" + id, true);
            xmlhttp.send();
        }
    </script>
</body>
</html>
