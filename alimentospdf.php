<?php
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "aguila011";
$database = "veterinaria";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer la codificación de caracteres a UTF-8
$conn->set_charset("utf8");

// Obtener datos de la tabla alimentos
$sql = "SELECT * FROM alimentos";
$result = $conn->query($sql);


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

$pdf->SetTextColor(0, 51, 153);
$pdf->SetCreator('Cotizacion');
$pdf->SetAuthor('IMCYC');
$pdf->SetTitle('Cotizacion');
$pdf->SetSubject('Cotizador');
$pdf->AddPage();

// Título
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(0, 0, 0); // Color negro para el texto
$pdf->Cell(0, 10, 'ALMACEN DE ALIMENTOS', 0, 1, 'C');
$pdf->Ln(20);

// Cabecera de la tabla
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(128, 0, 128); // Morado para la cabecera
$pdf->SetTextColor(255, 255, 255); // Texto blanco
$pdf->Cell(30, 10, 'ID', 1, 0, 'C', 1);
$pdf->Cell(70, 10, 'Nombre', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Precio', 1, 0, 'C', 1);
$pdf->Cell(60, 10, 'Cantidad Disponible', 1, 1, 'C', 1);

// Contenido de la tabla
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0, 0, 0); // Texto negro

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(70, 10, ($row['nombre']), 1, 0, 'L');
    $pdf->Cell(30, 10, '$' . $row['precio'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['cantidad_disponible'], 1, 1, 'C');
}

// Salida del PDF
$pdf->Output('almacen_alimentos.pdf', 'I');
?>
