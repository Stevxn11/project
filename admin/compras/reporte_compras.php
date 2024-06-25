<?php
require_once '../config/database.php';
require_once '../config/config.php';
require('../fpdf/plantilla_reporte.php');

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'admin')) {
    header('Location: ../../index.php');
    exit;
}

$db = new Database();
$con = $db->conectar();;

$fechaIni = $_POST['fecha_ini'] ?? '2021-01-01';
$fechaFin = $_POST['fecha_fin'] ?? '2024-06-18';

$query = "SELECT date_format(c.fecha,'%d/%m/%Y %H:%i') AS fechaHora, c.status, c.total, CONCAT(cli.nombres,' ',cli.apellidos) AS clientes 
FROM compra AS c
INNER JOIN clientes AS cli ON c.id_cliente = cli.id
WHERE DATE(c.fecha) BETWEEN ? AND ?
ORDER BY DATE(fecha) ASC";
$result = $con->prepare($query);
$result->execute([$fechaIni,$fechaFin]);

$datos = [
  'fechaIni' => $fechaIni,
  'fechaFin' => $fechaFin,
];

$pdf = new PDF ('P', 'mm', 'Letter', $datos);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(50, 6, $row['fechaHora'], 1, 0);
    $pdf->Cell(50, 6, $row['status'], 1, 0);
    $pdf->Cell(60, 6, $row['clientes'], 1, 0);
    $pdf->Cell(30, 6, $row['total'], 1, 1);
    
}

$pdf->Output();

require_once "../header.php";
