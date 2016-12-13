<?php 
	session_start();
	include_once 'admin/php/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Ofertas</title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<link href="<?php echo $raiz;?>css/ofertas.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<div class="container-fluid">
		<div class="row">
			<img alt="Logo" src="img/ofertas_logo.png" style="width: 210px; height: auto;" />
		</div>

		<?php
			$strSalida = "";
			
			$strSQL = "SELECT t.NumeTipo, t.NombTipo, t.Imagen, t.Precio,";
			$strSQL.= " f.NombFabr, f.Logo, f.Dominio";
			$strSQL.= " FROM tipologias t";
			$strSQL.= " INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
			$strSQL.= " WHERE t.Oferta = 1";
			$strSQL.= " AND f.Estado = 1";
			$strSQL.= " ORDER BY f.NumeFabr, t.NombTipo";
			
			$tipologias = cargarTabla($strSQL);

			$I = 1;
			
			$strSalida.= '<div class="row divTipologias">';
			while ($fila = $tipologias->fetch_array()) {
				if ($I == 4) {
					$strSalida.= $crlf.'</div>';
					$strSalida.= '<div class="row divTipologias">';
					$I = 1;
				}
				
				$strSalida.= $crlf.'<div class="col-md-4 marginTop40 txtCenter">';
				
				$strSalida.= $crlf.'<div class="text-left">';
				$strSalida.= $crlf.'<a href="fabrica/'. $fila["Dominio"] .'/" title="'. $fila["NombFabr"] .'">';
				$strSalida.= '<img src="admin/'. $fila["Logo"] . '" style="width: 60%; height: auto;" />';
				$strSalida.= $crlf.'</a>';
				$strSalida.= $crlf.'</div>';
				
				$strSalida.= $crlf.'<div class="imgTipologia clickable" data-url="fabrica/'. $fila["Dominio"] . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'/" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;"></div>';
				$strSalida.= $crlf.'<br>';
				$strSalida.= $crlf.'<div class="cuadroNegro">';
				$strSalida.= $fila["NombTipo"];
				$strSalida.= '<br><span class="txtBold rojo">$ '. $fila["Precio"] . '</span>';
				$strSalida.= '</div>';
				$strSalida.= $crlf.'</div>';
				$I++;
			}
			$strSalida.= $crlf.'</div>';
				
			echo $strSalida;
			
			if (isset($tipologias))
				$tipologias->free();
		?>
		
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>