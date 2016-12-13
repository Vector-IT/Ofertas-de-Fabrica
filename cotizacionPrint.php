<?php 
	session_start();
	include_once 'admin/php/conexion.php';
	
	$numeCoti = $_GET["NumeCoti"];

	$strSQL = "SELECT c.TipoCoti, c.FechCoti, t.NombTipo, t.NombFabr, t.Imagen, t.Logo,";
	$strSQL.= " c.Nombre, c.Telefono, c.Email, c.Adicionales, c.Precio, c.Entrega,";
	$strSQL.= " c.Porcentaje, c.CantCuotas, c.MontoCuota, t.Imagen ImagenTipo, t.PrecioKm, c.Distancia";
	$strSQL.= " FROM cotizaciones c";
	$strSQL.= " INNER JOIN (SELECT t.NumeTipo, t.NombTipo, t.Imagen, f.NombFabr, f.Logo, f.PrecioKm";
	$strSQL.= "				FROM tipologias t";
	$strSQL.= "				INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
	$strSQL.= "				) t ON c.NumeTipo = t.NumeTipo";
	$strSQL.= " WHERE c.NumeCoti = " . $numeCoti;
	
	$tabla = cargarTabla($strSQL);
	
	if ($tabla->num_rows == 0) {
		header("Location:index.php");
	}
	
	$cotizacion = $tabla->fetch_array();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Cotizaci&oacute;n</title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<script src="<?php echo $raiz;?>js/cotizacionPrint.js"></script>
</head>	
<body>
	<div class="container-fluid">
		<div class="row">
			<h1><img alt="" src="img/logo.png"> Cotizaci&oacute;n</h1>
			<hr />
		</div>
		
		<div class="row">
			<h3>Vivienda seleccionada</h3>
			<div class="txtBig">
				<img alt="" src="admin/<?php echo $cotizacion["Logo"];?>" style="width: 150px; height: auto;">- <?php echo $cotizacion["NombTipo"];?>
				<div>
					Precio: $<?php echo $cotizacion["Precio"];?>
				</div>
				<div>
					Distancia del traslado: <?php echo $cotizacion["Distancia"];?>
				</div>
				<div>
					<?php
						$precio = round(floatval(str_replace(' km', '', $cotizacion["Distancia"]) * $cotizacion["PrecioKm"]), 2);
					?>
					Precio del traslado: $ <?php echo $precio;?>
				</div>
				<div>
					Adicionales: <?php echo $cotizacion["Adicionales"];?>
				</div>
			</div>
		</div>
		<div class="row">
			<h3>M&eacute;todo de pago</h3>
			<div class="txtBold txtBig">
			<?php
				switch ($cotizacion["TipoCoti"]) {
					case "1":
						echo "Venta directa";
						break;
					case "2":
						echo "Financiaci&oacute;n";
						echo '<div style="font-weight: normal !important;">Entrega: $' . $cotizacion["Entrega"];
						echo '<br>Cantidad de cuotas: ' . $cotizacion["CantCuotas"];
						echo '<br>Monto de la cuota: $' . $cotizacion["MontoCuota"];
						echo '</div>';
						break;
					case "3":
						echo "Plan a medida";
						break;
				}
			?>
			</div>
		</div>
		<div class="row">
			<h3>Datos de contacto</h3>
			<p><span class="txtBold">Nombre: </span><?php echo $cotizacion["Nombre"];?></p>
			<p><span class="txtBold">Tel&eacute;fono: </span><?php echo $cotizacion["Telefono"];?></p>
			<p><span class="txtBold">E-mail: </span><?php echo $cotizacion["Email"];?></p>
		</div>
	</div>
	
	<?php $tabla->free(); ?>
</body>
</html>