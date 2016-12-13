<?php 
	session_start();
	include_once 'admin/php/conexion.php';

	$Filtro = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["CantHabi"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}
			
			switch ($_POST["CantHabi"]) {
				case 1:
					$Filtro = " CantHabi = 1";
					break;
				case 2:
					$Filtro = " CantHabi = 2";
					break;
				case 3:
					$Filtro = " CantHabi >= 3";
					break;
			}
		}
		
		if (isset($_POST["Precio"])) {
			switch ($_POST["Precio"]) {
				case 1:
					if ($Filtro != "") {$Filtro.= " AND ";}
					
					$Filtro.= " Precio BETWEEN 50000 AND 100000";
					break;
				case 2:
					if ($Filtro != "") {$Filtro.= " AND ";}
					
					$Filtro.= " Precio BETWEEN 100000 AND 150000";
					break;
				case 3:
					if ($Filtro != "") {$Filtro.= " AND ";}
					
					$Filtro.= " Precio BETWEEN 150000 AND 200000";
					break;
				case 4:
					if ($Filtro != "") {$Filtro.= " AND ";}
					
					$Filtro.= " Precio >= 200000";
					break;
			}
		}
		
		if (isset($_POST["chkBano"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkBano = 1";
		}
		
		if (isset($_POST["chkGriferia"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkGriferia = 1";
		}
		
		if (isset($_POST["chkPinturaExt"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkPinturaExt = 1";
		}
		
		if (isset($_POST["chkPinturaInt"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkPinturaInt = 1";
		}
		
		if (isset($_POST["chkBacha"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkBacha = 1";
		}
		
		if (isset($_POST["chkMesada"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkMesada = 1";
		}
		
		if (isset($_POST["chkBajoMesada"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkBajoMesada = 1";
		}
		
		if (isset($_POST["chkAlacena"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkAlacena = 1";
		}
		
		if (isset($_POST["chkTanqueAgua"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkTanqueAgua = 1";
		}
		
		if (isset($_POST["chkElectrico"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}

			$Filtro.= " chkElectrico = 1";
		}

		if (isset($_POST["search-text"])) {
			if ($Filtro != "") {$Filtro.= " AND ";}
			
			$Filtro.= " NombTipo LIKE '%{$_POST["search-text"]}%'";
		}
		
		
		$strSQL = "SELECT t.NumeTipo, t.NombTipo, t.Imagen, f.Dominio, f.Logo, t.Precio";
		$strSQL.= " FROM tipologias t";
		$strSQL.= " INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
		$strSQL.= " WHERE f.Estado = 1";
		
		if ($Filtro != "") {$strSQL.= " AND ";}
		
		$strSQL.= $Filtro;
		
		$tipologias = cargarTabla($strSQL);
	}
	else {
		header("Location:index.php");
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Resultados de B&uacute;squeda</title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<link href="<?php echo $raiz;?>css/ofertas.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<div class="container-fluid">
		<div class="row">
			<h1>Resultados de B&uacute;squeda</h1>
		</div>
		<div class="row">
		<?php 
			$strSalida = "";
			if ($tipologias->num_rows > 0) {
				while ($fila = $tipologias->fetch_array()) {
					$strSalida.= $crlf.'<div class="col-md-4 marginTop40 txtCenter clickable" data-url="fabrica/'. $fila["Dominio"] . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'/">';
					$strSalida.= $crlf.'<div class="imgTipologia" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;">';
					$strSalida.= $crlf.'<img alt="" src="admin/'. $fila["Logo"] .'" class="floatLeft" style="width: 30%; height: auto;">';
					$strSalida.= $crlf.'</div>';
					$strSalida.= $crlf.'<div style="padding: 10px 0;">';
					$strSalida.= $crlf.'<span class="floatRight">$ '. $fila["Precio"] .'</span>';
					$strSalida.= $crlf.'<div class="clearer"></div>';
					$strSalida.= $crlf.'</div>';
					
					$strSalida.= $crlf.'<span class="cuadroNegro">';
					$strSalida.= $fila["NombTipo"];
					$strSalida.= '</span>';
					$strSalida.= $crlf.'</div>';
				}
			}
			else {
				$strSalida = "<h3>La b&uacute;squeda no arroj&oacute; resultados.</h3>";
			}
			
			echo $strSalida;
				
			if (isset($tipologias))
				$tipologias->free();
		?>
		</div>
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>