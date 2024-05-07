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

// Obtener datos de la tabla citas
$sql = "SELECT * FROM citas";
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
$pdf->Cell(0, 10, 'LISTA DE CITAS', 0, 1, 'C');
$pdf->Ln(20);
$html = '';
$html = '<table border="1">';
$html .= '<tr bgcolor="#800080" color="#FFFFFF">';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>ID</h5></th>';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>Cliente</h5></th>';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>Mascota</h5></th>';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>Servicio</h5></th>';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>Costo</h5></th>';
$html .= '<th style="text-align: center; padding: 5px; font-size: 15px;"><h5>Observaciones</h5></th>';
$html .= '</tr>';

// Llenar la tabla con datos de la base de datos
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>' . $row['id'] . '</h5></td>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>' . htmlspecialchars($row['cliente']) . '</h5></td>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>' . htmlspecialchars($row['mascota']) . '</h5></td>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>' . htmlspecialchars($row['servicio']) . '</h5></td>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>$' . number_format($row['costo'], 2) . '</h5></td>';
    $html .= '<td style="text-align: center; padding: 5px; font-size: 15px;"><h5>' . htmlspecialchars($row['observaciones']) . '</h5></td>';
    $html .= '</tr>';
}

$html .= '</table>';

// Escribir tabla en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('lista_citas.pdf', 'I');
?>
