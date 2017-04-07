<?php
include_once 'admin/php/conexion.php';
require('php/fpdf.php');

$numeCoti = $_GET["NumeCoti"];

$strSQL = "SELECT c.TipoCoti, c.FechCoti, t.NombTipo, t.NombFabr, t.Imagen, t.Logo,";
$strSQL.= " c.Nombre, c.Telefono, c.Email, c.Adicionales, c.Precio, c.Entrega,";
$strSQL.= " c.Porcentaje, c.CantCuotas, c.MontoCuota, t.Imagen ImagenTipo, t.PrecioKm, c.Distancia,";
$strSQL.= " chkBano, chkGriferia, chkPinturaExt, chkPinturaInt, chkBacha, chkMesada, chkBajoMesada, chkAlacena, chkTanqueAgua, chkElectrico";
$strSQL.= " FROM cotizaciones c";
$strSQL.= " INNER JOIN (SELECT t.NumeTipo, t.NombTipo, t.Imagen, f.NombFabr, f.Logo, f.PrecioKm, chkBano, chkGriferia, chkPinturaExt, chkPinturaInt, chkBacha, chkMesada, chkBajoMesada, chkAlacena, chkTanqueAgua, chkElectrico";
$strSQL.= "				FROM tipologias t";
$strSQL.= "				INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
$strSQL.= "				) t ON c.NumeTipo = t.NumeTipo";
$strSQL.= " WHERE c.NumeCoti = " . $numeCoti;

$tabla = cargarTabla($strSQL);

if ($tabla->num_rows == 0) {
	header("Location:index.php");
}

$cotizacion = $tabla->fetch_array();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('img/logo.png', 10, 8, 50);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(75);
$pdf->Cell(40, 15, utf8_decode('SOLICITUD DE COTIZACIÓN'), 0, 0, 'C');
$pdf->SetDrawColor(190, 190, 190);
$pdf->Line(10, 35, 200, 35);
$pdf->Ln(25);

$pdf->SetFont('Arial', 'U', 16);
//$pdf->Cell(35);
$pdf->Cell(0, 20, utf8_decode("Vivienda seleccionada"), 0, 0);
$pdf->Ln(12);

$pdf->SetFont('Arial', '', 12);
$pdf->Image('admin/'.$cotizacion["Logo"], 10, 50, 40);
//$pdf->Cell(68);
$pdf->Cell(36);
$pdf->Cell(30, 20, utf8_decode(" - " . $cotizacion["NombTipo"]), 0, 0);
$pdf->Ln(12);
$pdf->Cell(15, 20, utf8_decode("Precio:"));
$pdf->Cell(30, 20, utf8_decode("$" . $cotizacion["Precio"]));
$pdf->Ln(6);
$pdf->Cell(25, 20, utf8_decode("Distancia de traslado: " . $cotizacion["Distancia"] . " km"));
$pdf->Ln(6);
$precio = round(floatval(str_replace(' km', '', $cotizacion["Distancia"]) * $cotizacion["PrecioKm"]), 2); 
$pdf->Cell(25, 20, utf8_decode("Precio del traslado: $ " . $precio));
$pdf->Ln(14);

$pdf->Cell(25, 6, utf8_decode("Adicionales:"));
//$pdf->MultiCell(150, 6, utf8_decode($cotizacion["Adicionales"]));
if ($cotizacion["chkBano"]) {
	$pdf->Cell(0, 20, utf8_decode("Baño"));
	$pdf->Ln(6);
}
if ($cotizacion["chkGriferia"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Grifería"));
	$pdf->Ln(6);
}
if ($cotizacion["chkPinturaExt"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Pintura exterior"));
	$pdf->Ln(6);
}
if ($cotizacion["chkPinturaInt"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Pintura interior"));
	$pdf->Ln(6);
}
if ($cotizacion["chkBacha"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Bacha"));
	$pdf->Ln(6);
}
if ($cotizacion["chkMesada"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Mesada"));
	$pdf->Ln(6);
}
if ($cotizacion["chkBajoMesada"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Bajo mesada"));
	$pdf->Ln(6);
}
if ($cotizacion["chkAlacena"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Alacena"));
	$pdf->Ln(6);
}
if ($cotizacion["chkTanqueAgua"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Tanque de agua"));
	$pdf->Ln(6);
}
if ($cotizacion["chkElectrico"]) {
	$pdf->Cell(25);
	$pdf->Cell(0, 20, utf8_decode("Kit eléctrico"));
	$pdf->Ln(6);
}

$pdf->Ln(15);

//$pdf->Image('img/cotizar.png', 13, 85, 30);
$pdf->SetFont('Arial', 'U', 16);
//$pdf->Cell(35);
$pdf->Cell(0, 20, utf8_decode("Método de pago"), 0, 0);
$pdf->Ln(12);

$pdf->SetFont('Arial', 'B', 12);
//$pdf->Cell(35);
switch ($cotizacion["TipoCoti"]) {
	case "1":
		$pdf->Cell(30, 20, utf8_decode('Venta directa'));
		break;
	case "2":
		$pdf->Cell(30, 20, utf8_decode('Financiación'));
		$pdf->SetFont('Arial', '', 12);
		$pdf->Ln(8);
		$pdf->Cell(30, 20, utf8_decode('Entrega: $' . $cotizacion["Entrega"]));
		$pdf->Ln(8);
		$pdf->Cell(30, 20, utf8_decode('Cantidad de cuotas: ' . $cotizacion["CantCuotas"]));
		$pdf->Ln(8);
		$pdf->Cell(30, 20, utf8_decode('Monto de la cuota: $' . $cotizacion["MontoCuota"]));
		break;
	case "3":
		$pdf->Cell(30, 20, utf8_decode('Plan a medida'));
		break;
}
$pdf->Ln(15);
$pdf->SetFont('Arial', 'U', 16);
$pdf->Cell(10, 20, utf8_decode("Datos de contacto"), 0, 0);
$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 15, utf8_decode("Nombre:"), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 15, utf8_decode($cotizacion["Nombre"]), 0, 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 15, utf8_decode("Teléfono:"), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 15, utf8_decode($cotizacion["Telefono"]), 0, 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 15, utf8_decode("E-mail:"), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 15, utf8_decode($cotizacion["Email"]), 0, 0);

$pdf->Image('admin/' . $cotizacion["ImagenTipo"], 120, 110, 80);

$tabla->free();

$pdf->Output('D', 'Cotizacion.pdf');
//$pdf->Output();
?>