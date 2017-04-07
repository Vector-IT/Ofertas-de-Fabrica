<?php 
	session_start();
	include_once 'admin/php/conexion.php';
	
	$dominio = $_GET["fabrica"];
	
	$tabla = cargarTabla("SELECT NumeFabr, NombFabr, Logo, Portada, Email, Descripcion, Telefono FROM fabricas WHERE Dominio = '{$dominio}'");
	
	if ($tabla->num_rows > 0) {
		$fabrica = $tabla->fetch_array();
		
		$tabla->free();
		
		$tipologias = cargarTabla("SELECT NumeTipo, NombTipo, Imagen, Oferta, Premium FROM tipologias WHERE NumeFabr = {$fabrica["NumeFabr"]} AND Mayorista != 1");
	}
	else
		header("location:index.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - <?php echo $fabrica["NombFabr"]?></title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<link href="<?php echo $raiz;?>css/fabrica.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $raiz;?>admin/css/wysihtml-stylesheet.css" rel="stylesheet" type="text/css">

    <meta property="og:title" content="<?php echo $fabrica["NombFabr"]?>" />
    <meta property="og:description" content="Ofertas de Fábrica! El sitio donde podrás encontrar las mejores ofertas y descuentos especiales de diferentes empresas desarrollistas de viviendas" />
	<meta property="og:image" content="http://ofertasdefabrica.com.ar/admin/<?php echo $fabrica["Logo"]?>" />
	
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<img alt="Portada" src="admin/<?php echo $fabrica["Portada"];?>" style="width: 100%; height: auto;" />
	
	<div class="divLogo">
		<div class="col-md-4 col-md-offset-4 txtCenter">
			<img alt="<?php echo $fabrica["NombFabr"]?>" src="admin/<?php echo $fabrica["Logo"];?>" style="width: 80%; height: auto;" />
		</div>
		<div class="col-md-4 txtRight">
			<div class="floatRight txtCenter clickable" data-toggle="modal" data-target="#chat-dialog">
			<img alt="Telemarketer" src="img/telemarketer.png" />
			<br><br>
			<span class="cajaRoja">Respondemos tu consulta online</span>
			</div>
		</div>
		<div class="clearer"></div>
	</div>
	
	<div>
		<span class="cajaRoja txtBold">OFERTAS DIRECTO DE F&Aacute;BRICA</span>
	</div>
	
	<div class="divTipologias">
		<?php
			$strSalida = "";
			while ($fila = $tipologias->fetch_array()) {
				$sinExtra = true;
				
				$strSalida.= $crlf.'<div class="col-md-4 marginTop40 txtCenter clickable" data-url="fabrica/'. $dominio . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'/">';
				$strSalida.= $crlf.'<div class="imgTipologia" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;"></div>';
				$strSalida.= $crlf.'<br>';

				if ($fila["Oferta"] == "1") {
					$strSalida.= $crlf.'<div class="floatLeft" style="color: dodgerblue;"><i class="fa fa-bookmark"></i> En oferta</div>';
					$sinExtra = false;
				}
				
				if ($fila["Premium"] == "1") {
					$strSalida.= $crlf.'<div class="floatRight" style="color: red;">Premium <i class="fa fa-star"></i></div>';
					$sinExtra = false;
				}
				
				if ($sinExtra)
					$strSalida.= $crlf.'<br>';
				
				$strSalida.= $crlf.'<div class="clearer"></div>';
				$strSalida.= $crlf.'<span class="cuadroNegro">';
				$strSalida.= $fila["NombTipo"];
				$strSalida.= '</span>';
				$strSalida.= $crlf.'</div>';
			}
			
			if (isset($tipologias))
				$tipologias->free();
			
			echo $strSalida;
		?>
		<div class="clearer"></div>
	</div>
	
	<div class="consulta marginTop40">
		<img alt="Consulta" src="img/fabrica-consulta.jpg" style=" width: 100%; height: auto;" />
	</div>
	<div class="fondoRojo txtCenter">
		<span class="cuadroBlanco clickable" data-js="$('#contactoFabrica-dialog').modal('show');">CONSULT&Aacute; CON EL FABRICANTE</span>
	</div>
	
	<div>
		<?php echo $fabrica["Descripcion"];?>
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php 
		include_once 'php/footer.php';
		include_once 'php/contactoFabrica.php';
		include_once 'php/chat-dialog.php';
	?>
</body>
</html>