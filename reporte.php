<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "vertrigo";
$database = "limpieza";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer la codificación de caracteres a UTF-8
$conn->set_charset("utf8");

// Obtener datos de la tabla productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Establecer color de fondo oscuro
$pdf->SetFillColor(50, 50, 50);
$pdf->Rect(0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'F');

// Logo
$pdf->Image('img/logo.jpg',10,10,30);

// Título
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(255, 255, 255); // Color blanco para el texto
$pdf->Cell(0,10,'ALMACEN',0,1,'C');
$pdf->Ln(10);

// Tabla
$pdf->SetFillColor(128, 0, 128); // Morado
$pdf->SetTextColor(255, 255, 255); // Texto blanco
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,10,'ID',1,0,'C', true);
$pdf->Cell(50,10,'Nombre',1,0,'C', true);
$pdf->Cell(30,10,'Precio',1,0,'C', true);
$pdf->Cell(30,10,'Cantidad',1,0,'C', true);
$pdf->Cell(40,10,'Categoria',1,1,'C', true);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(255, 255, 255); // Texto blanco

while($row = $result->fetch_assoc()) {
    $pdf->Cell(30,10,$row['id'],1,0);
    // Obtener la posición actual Y
    $Y_Position = $pdf->GetY();
    // Usar MultiCell para el nombre del producto
    $pdf->SetFont('Arial','',10); // Establecer la fuente para el nombre
    $pdf->MultiCell(50,10,utf8_decode($row['nombre']),1);
    // Establecer la posición Y al mismo nivel que la celda anterior
    $pdf->SetY($Y_Position);
    $pdf->SetX(90); // Establecer la posición X para el siguiente campo
    $pdf->Cell(30,10,'$'.$row['precio'],1,0);
    $pdf->Cell(30,10,$row['cantidad'],1,0);
    // Usar MultiCell para la categoría
    $pdf->SetFont('Arial','',10); // Establecer la fuente para la categoría
    $pdf->MultiCell(40,10,utf8_decode($row['categoria']),1);
}

// Establecer color de fondo oscuro
$pdf->SetFillColor(50, 50, 50);
$pdf->Rect(0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'F');
$pdf->SetFillColor(128, 0, 128); // Morado
$pdf->SetTextColor(255, 255, 255); // Texto blanco
// Salida del PDF
$pdf->Output();
?>
