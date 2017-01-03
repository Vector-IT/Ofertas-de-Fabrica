<?php 
	session_start();
	
	if ((!isset($_SESSION['is_logged_in'])) ||
			($_SESSION['TipoUsua'] != "1")) {
		header("Location:login.php?returnUrl=" . $_SERVER[REQUEST_URI]);
		die();
	}
	include "conexion.php";

	header("Content-Type: application/vnd.ms-excel");
	
	header("Expires: 0");
	
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	header("content-disposition: attachment;filename=Cotizaciones.xls");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cotizaciones</title>
		
		<style type="text/css">
			th, td {border: 1px solid;}
		</style>
	</head>
	<body>
	<?php 
		$strSQL = "SELECT c.NumeCoti, c.NumeTipo, t.NombFabr, t.NombTipo, c.TipoCoti, c.FechCoti, c.NumeEsta,";
		$strSQL.= " c.Nombre, c.Telefono, c.Email, c.Adicionales, c.Precio, c.Entrega, c.Porcentaje, c.CantCuotas,";
		$strSQL.= " c.MontoCuota, c.Provincia, c.Ciudad";
		$strSQL.= " FROM cotizaciones c";
		$strSQL.= " INNER JOIN (SELECT t.NumeTipo, t.NombTipo, f.NombFabr";
		$strSQL.= "				FROM tipologias t";
		$strSQL.= "				INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
		$strSQL.= "				) t ON c.NumeTipo = t.NumeTipo";
		$strSQL.= " ORDER BY c.NumeCoti";
		
		$tabla = cargarTabla($strSQL);
		
		$salida = '';
		
		if (mysqli_num_rows($tabla) > 0) {
			$salida.= $crlf.'<table class="table table-striped table-condensed">';
			$salida.= $crlf.'<tr>';
			$salida.= $crlf.'<th>Numero</th>';
			$salida.= $crlf.'<th>Fecha</th>';
			$salida.= $crlf.'<th>F&aacute;brica</th>';
			$salida.= $crlf.'<th>Tipolog&iacute;a</th>';
			$salida.= $crlf.'<th>Adicionales</th>';
			$salida.= $crlf.'<th>Tipo de cotizaci&oacute;n</th>';
			$salida.= $crlf.'<th>Datos de financiaci&oacute;n</th>';
			$salida.= $crlf.'<th>Datos de contacto</th>';
			$salida.= $crlf.'<th>Provincia</th>';
			$salida.= $crlf.'<th>Ciudad</th>';
			$salida.= $crlf.'<th>Estado</th>';
			$salida.= $crlf.'</tr>';
				
			while ($fila = $tabla->fetch_array()) {
				$salida.= $crlf.'<tr>';
					
				//Numero
				$salida.= $crlf.'<td>'.$fila[0].'</td>';
					
				//Fecha
				$salida.= $crlf.'<td>'.$fila["FechCoti"].'</td>';
					
				//Fabrica
				$salida.= $crlf.'<td>'.$fila["NombFabr"].'</td>';
				//Tipologia
				$salida.= $crlf.'<td>'.$fila["NombTipo"].'</td>';
				//Adicionales
				$salida.= $crlf.'<td>'.$fila["Adicionales"].'</td>';
				//Tipo de cotización
				switch ($fila["TipoCoti"]) {
					case "1": 
						$salida.= $crlf.'<td>Venta directa</td><td></td>';
						break;
					case "2":
						$salida.= $crlf.'<td>Financiaci&oacute;n</td>';
						$salida.= $crlf.'<td>Entrega: $'.$fila["Entrega"].'<br>';
						$salida.= $crlf.'Inter&eacute;s anual: '.$fila["Porcentaje"].'%<br>';
						$salida.= $crlf.'Cantidad de cuotas: '.$fila["CantCuotas"].'<br>';
						$salida.= $crlf.'Monto de la cuota: $'.$fila["MontoCuota"];
						$salida.= $crlf.'</td>';
						break;
					case "3":
						$salida.= $crlf.'<td>Plan a medida</td><td></td>';
						break;
				}
				//Datos
				$salida.= $crlf.'<td>'.$fila["Nombre"].'<br>';
				$salida.= $crlf.$fila["Telefono"].'<br>';
				$salida.= $crlf.$fila["Email"].'</td>';
				//Provincia
				$salida.= $crlf.'<td>'.$fila["Provincia"].'</td>';
				//Ciudad
				$salida.= $crlf.'<td>'.$fila["Ciudad"].'</td>';
				//Estado
				if ($fila["NumeEsta"] == "0")
					$salida.= $crlf.'<td>Inactiva</td>';
				elseif ($fila["NumeEsta"] == "1")
					$salida.= $crlf.'<td>Activa</td>';
				elseif ($fila["NumeEsta"] == "2")
					$salida.= $crlf.'<td>Procesada</td>';
						
				$salida.= $crlf.'</tr>';
			}
			
			$salida.= $crlf.'</table>';
		}
		$tabla->free();
		
		echo $salida;
	?>
	</body>

</html>