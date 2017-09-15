<?php 
	session_start();
	include_once 'admin/php/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Mayorista</title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<link href="<?php echo $raiz;?>css/ofertas.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<div class="container-fluid">
		<div class="row">
			<h1>Venta Mayorista</h1>
		</div>
		<?php
			$tabla = cargarTabla("SELECT NumeFabr, Logo, NombFabr, Dominio FROM fabricas WHERE NumeFabr IN (SELECT NumeFabr FROM tipologias WHERE Mayorista = 1)");
			$strSalida = "";
			
			while ($fabrica = $tabla->fetch_array()) {
				$strSalida.= $crlf.'<div class="row marginTop40">';
				$strSalida.= $crlf.'<div class="col-md-2">';
				$strSalida.= $crlf.'<a href="fabrica/'. $fila["Dominio"] .'" title="'. $fila["NombFabr"] .'">';
				$strSalida.= '<img src="admin/'. $fabrica["Logo"] . '" style="width: 100%; height: auto;" />';
				$strSalida.= $crlf.'</a>';
				$strSalida.= $crlf.'</div>';
				$strSalida.= $crlf.'</div>';
			
				$strSalida.= '<div class="row divTipologias">';
				$tipologias = cargarTabla("SELECT NumeTipo, NombTipo, Imagen, Precio FROM tipologias WHERE Mayorista = 1 AND NumeFabr = {$fabrica["NumeFabr"]}");
			
				while ($fila = $tipologias->fetch_array()) {
					$strSalida.= $crlf.'<div class="col-md-4 marginTop40 txtCenter clickable" data-url="fabrica/'. $fabrica["Dominio"] . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'/">';
					$strSalida.= $crlf.'<div class="imgTipologia" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;"></div>';
					$strSalida.= $crlf.'<br><br>';
					// $strSalida.= $crlf.'<span class="cuadroNegro">';
					// $strSalida.= $fila["NombTipo"];
					// $strSalida.= '</span>';
					$strSalida.= $crlf.'<div class="cuadroNegro">';
					$strSalida.= $fila["NombTipo"];
					$strSalida.= '<br><span class="txtBold rojo">$ '. $fila["Precio"] . '</span>';
					$strSalida.= '</div>';
					$strSalida.= $crlf.'</div>';
				}
				$strSalida.= $crlf.'</div>';
					
			}
				
			echo $strSalida;
			
			if (isset($tipologias))
				$tipologias->free();
					
			if (isset($tabla))
				$tabla->free();
		?>
		
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>