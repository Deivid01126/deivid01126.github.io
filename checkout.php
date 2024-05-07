<?php
session_start();

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

require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

    public function Header() {
        $this->SetY(10);
        $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
        $this->Line(10, $this->GetY() + 15, $this->getPageWidth() - 10, $this->GetY() + 15);

        $this->Image('Imagenes/logo.jpg', 170, 3, 20, 20, 'JPG', 'http://www.imcyc.com', '', true, 150, '', false, false, 0, false, false, false);

        $this->SetTextColor(0, 51, 153);
        $this->SetFont('helvetica', 'B', 10);
        
        $this->Cell(0, 50, 'Clínica Veterinaria Amigo Fiel', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() { 

        $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 51, 153)));
        $this->Line(10, $this->getY() - 20, $this->getPageWidth() - 10, $this->getY() - 20);

        $this->SetY(-25);
        // Set font
        $this->SetTextColor(0, 51, 153);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Cuatutitlan Mexico , Fraccionamiento Rancho San Blas, C.P. 54870, EDOMEX ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Ln();
        $this->Cell(0, 10, ' Tel. 55 26730982', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


if (isset($_POST['generate_invoice'])) {
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetCreator('Cotizacion');
        $pdf->SetAuthor('CVAF');
        $pdf->SetTitle('Cotizacion');
        $pdf->SetSubject('Cotizador');
        $pdf->AddPage();

        $pdf->SetFont('helvetica','B',16);
        $pdf->Cell(0, 5, "Ticket de Compra", 0, 1);
        $pdf->Ln();

        $pdf->SetFont('helvetica','',14);
        $total_price = 0;
        $mensaje = "Agradecemos de antemano la confianza depositada en el CVAF para desarrollar la presente compra de los mejores alimentos y con la mayor calidad ofrecida para nuestros queridos compañeros de vida.";
        $pdf->MultiCell(0, 10, $mensaje, 0, 'L');
        $pdf->Ln();

        $pdf->Cell(50, 10, 'ID', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Precio', 1, 1, 'C');

        foreach ($_SESSION['cart'] as $item) {
            $sql = "SELECT * FROM alimentos WHERE id=$item";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pdf->Cell(50, 10, $row["id"], 1, 0, 'C');
                $pdf->Cell(70, 10, $row["nombre"], 1, 0, 'C');
                $pdf->Cell(50, 10, '$'.number_format($row["precio"], 2), 1, 1, 'C');
                $total_price += $row["precio"];
            }
        }

        $pdf->Cell(120, 10, 'Total:', 1, 0, 'R');
        $pdf->Cell(50, 10, '$'.number_format($total_price, 2), 1, 1, 'C');

        $pdf->Output('factura.pdf', 'D');
        exit;
    } else {
        echo "No hay productos en el carrito.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Alimentos para Mascotas</title>
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
        .checkout-btn, .invoice-btn {
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
        .checkout-btn:hover, .invoice-btn:hover {
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
        <h1>Checkout - Alimentos para Mascotas</h1>
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
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        $total_price = 0;
                        foreach ($_SESSION['cart'] as $item) {
                            $sql = "SELECT * FROM alimentos WHERE id=$item";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "<tr>
                                    <td>". $row["id"]. "</td>
                                    <td>". $row["nombre"]. "</td>
                                    <td>". $row["marca"]. "</td>
                                    <td>". $row["tipo"]. "</td>
                                    <td>$". number_format($row["precio"], 2). "</td>
                                </tr>";
                                $total_price += $row["precio"];
                            }
                        }
                        echo "<tr>
                            <th colspan='4'>Total:</th>
                            <td>$". number_format($total_price, 2). "</td>
                        </tr>";
                    } else {
                        echo "<tr><td colspan='5'>No hay productos en el carrito</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        <form method="post">
            <button type="submit" name="generate_invoice" class="invoice-btn">Generar Factura</button>
        </form>
        <a href="ventas.php" class="checkout-btn">Volver a Comprar</a>
    </div>
</body>
</html>
