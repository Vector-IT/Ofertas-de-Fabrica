<?php
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])) {
		header("Location:login.php");
		die();
	}
	
	include("conexion.php");
	include("upload_file.php");
	
	$operacion = $_POST["operacion"];
	
	if (isset($_POST["NumeTipo"])) {
		$NumeTipo = $_POST["NumeTipo"];
	}
	
	if (isset($_POST["NombTipo"])) {
		$NombTipo = str_replace("'", "\'", $_POST["NombTipo"]);
	}
	
	if (isset($_POST["Subtitulo"])) {
		$Subtitulo = str_replace("'", "\'", $_POST["Subtitulo"]);
	}
	
	if (isset($_POST["NumeFabr"])) {
		$NumeFabr = $_POST["NumeFabr"];
	}
	
	if (isset($_POST["CantHabi"])) {
		$CantHabi = $_POST["CantHabi"];
	}
	
	if (isset($_POST["Precio"])) {
		$Precio = $_POST["Precio"];
	}
	
	if (isset($_POST["Entrega"])) {
		$Entrega = $_POST["Entrega"];
	}
	
	if (isset($_POST["Tipologia"])) {
		$Tipologia = str_replace("'", "\'", $_POST["Tipologia"]);
	}
	
	if (isset($_POST["Superficie"])) {
		$Superficie = str_replace("'", "\'", $_POST["Superficie"]);
	}
	
	if (isset($_POST["Opcionales"])) {
		$Opcionales = str_replace("'", "\'", $_POST["Opcionales"]);
	}
	
	if (isset($_POST["chkBano"])) {
		$chkBano = $_POST["chkBano"];
	}
	else {
		$chkBano = 0;
	}
	
	if (isset($_POST["chkGriferia"])) {
		$chkGriferia = $_POST["chkGriferia"];
	}
	else {
		$chkGriferia = 0;
	}
	
	if (isset($_POST["chkPinturaExt"])) {
		$chkPinturaExt = $_POST["chkPinturaExt"];
	}
	else {
		$chkPinturaExt = 0;
	}
	
	if (isset($_POST["chkPinturaInt"])) {
		$chkPinturaInt = $_POST["chkPinturaInt"];
	}
	else {
		$chkPinturaInt = 0;
	}
	
	if (isset($_POST["chkBacha"])) {
		$chkBacha = $_POST["chkBacha"];
	}
	else {
		$chkBacha = 0;
	}
	
	if (isset($_POST["chkMesada"])) {
		$chkMesada = $_POST["chkMesada"];
	}
	else {
		$chkMesada = 0;
	}
	
	if (isset($_POST["chkBajoMesada"])) {
		$chkBajoMesada = $_POST["chkBajoMesada"];
	}
	else {
		$chkBajoMesada = 0;
	}
	
	if (isset($_POST["chkAlacena"])) {
		$chkAlacena = $_POST["chkAlacena"];
	}
	else {
		$chkAlacena = 0;
	}
	
	if (isset($_POST["chkTanqueAgua"])) {
		$chkTanqueAgua = $_POST["chkTanqueAgua"];
	}
	else {
		$chkTanqueAgua = 0;
	}
	
	if (isset($_POST["chkElectrico"])) {
		$chkElectrico = $_POST["chkElectrico"];
	}
	else {
		$chkElectrico = 0;
	}
	
	if (isset($_POST["Oferta"])) {
		$Oferta = $_POST["Oferta"];
	}
	else {
		$Oferta = 0;
	}
	
	if (isset($_POST["Premium"])) {
		$Premium = $_POST["Premium"];
	}
	else {
		$Premium = 0;
	}
	
	if (isset($_POST["Mayorista"])) {
		$Mayorista = $_POST["Mayorista"];
	}
	else {
		$Mayorista = 0;
	}
	
	if (isset($_POST["Financiacion"])) {
		$Financiacion = $_POST["Financiacion"];
	}
	else {
		$Financiacion = 0;
	}
	
	if (isset($_POST["Porcentaje"])) {
		$Porcentaje = $_POST["Porcentaje"];
	}
	else {
		$Porcentaje = 0;
	}
	
	if (isset($_POST["CantCuotas"])) {
		$CantCuotas = $_POST["CantCuotas"];
	}
	else {
		$CantCuotas = 0;
	}
	
	if (isset($_POST["ModificarPDF"])) {
		$ModificarPDF = $_POST["ModificarPDF"];
	}
	else {
		$ModificarPDF = 0;
	}
	
	switch ($operacion) {
		case 0: //INSERT
			$NumeTipo = buscarDato("SELECT COALESCE(MAX(NumeTipo), 0) + 1 Numero FROM tipologias");
			
			if (!empty($_FILES["Imagen"])) {
				$temp = explode(".", $_FILES["Imagen"]["name"]);
				$extension = end($temp);

				$archivo = $NumeTipo . "-Imagen." . $extension;
				$Imagen = "imgTipologias/" . $archivo;
				 
				subir_archivo($_FILES["Imagen"], "../imgTipologias", $archivo);
			}
			
			if (!empty($_FILES["Portada"])) {
				$temp = explode(".", $_FILES["Portada"]["name"]);
				$extension = end($temp);
				
				$archivo = $NumeTipo . "-Portada." . $extension;
				$Portada = "imgTipologias/" . $archivo;
					
				subir_archivo($_FILES["Portada"], "../imgTipologias", $archivo);
			}

			if (!empty($_FILES["Plano"])) {
				$temp = explode(".", $_FILES["Plano"]["name"]);
				$extension = end($temp);
					
				$archivo = $NumeTipo . "-Plano." . $extension;
				$Plano = "imgTipologias/" . $archivo;
					
				subir_archivo($_FILES["Plano"], "../imgTipologias", $archivo);
			}

			if (!empty($_FILES["ArchivoPDF"])) {
				$temp = explode(".", $_FILES["ArchivoPDF"]["name"]);
				$extension = end($temp);
					
				$archivo = $NumeTipo . "-PDF." . $extension;
				$PDF = "imgTipologias/" . $archivo;
					
				subir_archivo($_FILES["ArchivoPDF"], "../imgTipologias", $archivo);
			}
				
			$strSQL = "INSERT INTO tipologias(NumeTipo, NombTipo, Subtitulo, Tipologia, Superficie, Opcionales, Imagen, Portada, Plano, NumeFabr, Precio, Entrega, chkBano, chkGriferia, chkPinturaExt, chkPinturaInt, chkBacha, chkMesada, chkBajoMesada, chkAlacena, chkTanqueAgua, chkElectrico, Oferta, Premium, CantHabi, Mayorista, Financiacion, Porcentaje, CantCuotas, PDF)";
			$strSQL.= " VALUES ({$NumeTipo}, '{$NombTipo}', '{$Subtitulo}', '{$Tipologia}', '{$Superficie}', '{$Opcionales}', '{$Imagen}', '{$Portada}', '{$Plano}', {$NumeFabr}, '{$Precio}', '{$Entrega}', {$chkBano}, {$chkGriferia}, {$chkPinturaExt}, {$chkPinturaInt}, {$chkBacha}, {$chkMesada}, {$chkBajoMesada}, {$chkAlacena}, {$chkTanqueAgua}, {$chkElectrico}, {$Oferta}, {$Premium}, {$CantHabi}, {$Mayorista}, {$Financiacion}, {$Porcentaje}, {$CantCuotas}, '{$PDF}')";

			$result = ejecutarCMD($strSQL);
			if (!$result)
				echo "Error al crear f&aacute;brica:<br/>" . $result . "<br/>" . $strSQL;
			else 
				echo "Tipolog&iacute;a Creada!";

			break;

		case 1: //UPDATE
			$strSQL = "SELECT Imagen, Portada, Plano, PDF FROM tipologias WHERE NumeTipo = " . $NumeTipo;
			$tabla = cargarTabla($strSQL);
			$fila = $tabla->fetch_array();
			$tabla->free();
			
			if (!empty($_FILES["Imagen"])) {
				unlink("../" . $fila["Imagen"]);
				
				$temp = explode(".", $_FILES["Imagen"]["name"]);
				$extension = end($temp);

				$archivo = $NumeTipo . "-Imagen." . $extension;
				$Imagen = "imgTipologias/" . $archivo;
				 
				subir_archivo($_FILES["Imagen"], "../imgTipologias", $archivo);
			}
			
			if (!empty($_FILES["Portada"])) {
				unlink("../" . $fila["Portada"]);
			
				$temp = explode(".", $_FILES["Portada"]["name"]);
				$extension = end($temp);
				
				$archivo = $NumeTipo . "-Portada." . $extension;
				$Portada = "imgTipologias/" . $archivo;
					
				subir_archivo($_FILES["Portada"], "../imgTipologias", $archivo);
			}
			
			if (!empty($_FILES["Plano"])) {
				unlink("../" . $fila["Plano"]);
					
				$temp = explode(".", $_FILES["Plano"]["name"]);
				$extension = end($temp);
			
				$archivo = $NumeTipo . "-Plano." . $extension;
				$Plano = "imgTipologias/" . $archivo;
					
				subir_archivo($_FILES["Plano"], "../imgTipologias", $archivo);
			}
			
			if ($ModificarPDF == "1") {
				if (!empty($_FILES["ArchivoPDF"])) {
					unlink("../" . $fila["PDF"]);
					
					$temp = explode(".", $_FILES["ArchivoPDF"]["name"]);
					$extension = end($temp);
						
					$archivo = $NumeTipo . "-PDF." . $extension;
					$PDF = "imgTipologias/" . $archivo;
						
					subir_archivo($_FILES["ArchivoPDF"], "../imgTipologias", $archivo);
				}
				else 
					$ModificarPDF = 0;
			}
			
			$strSQL = "UPDATE tipologias ";
			$strSQL.= " SET NombTipo = '{$NombTipo}'";
			$strSQL.= ", Subtitulo = '{$Subtitulo}'";
			$strSQL.= ", Tipologia = '{$Tipologia}'";
			$strSQL.= ", Superficie = '{$Superficie}'";
			$strSQL.= ", Opcionales = '{$Opcionales}'";
			$strSQL.= ", Precio = '{$Precio}'";
			$strSQL.= ", Entrega = '{$Entrega}'";
			$strSQL.= ", NumeFabr = {$NumeFabr}";
			
			$strSQL.= ", chkBano = {$chkBano}";
			$strSQL.= ", chkGriferia = {$chkGriferia}";
			$strSQL.= ", chkPinturaExt = {$chkPinturaExt}";
			$strSQL.= ", chkPinturaInt = {$chkPinturaInt}";
			$strSQL.= ", chkBacha = {$chkBacha}";
			$strSQL.= ", chkMesada = {$chkMesada}";
			$strSQL.= ", chkBajoMesada = {$chkBajoMesada}";
			$strSQL.= ", chkAlacena = {$chkAlacena}";
			$strSQL.= ", chkTanqueAgua = {$chkTanqueAgua}";
			$strSQL.= ", chkElectrico = {$chkElectrico}";
			$strSQL.= ", Oferta = {$Oferta}";
			$strSQL.= ", Premium = {$Premium}";
			$strSQL.= ", CantHabi = {$CantHabi}";
			$strSQL.= ", Mayorista = {$Mayorista}";
			$strSQL.= ", Financiacion = {$Financiacion}";
			$strSQL.= ", Porcentaje = {$Porcentaje}";
			$strSQL.= ", CantCuotas = {$CantCuotas}";
			
			if (!empty($_FILES["Imagen"]))
				$strSQL.= ", Imagen = '{$Imagen}'";
			
			if (!empty($_FILES["Portada"]))
				$strSQL.= ", Portada = '{$Portada}'";
			
			if (!empty($_FILES["Plano"]))
				$strSQL.= ", Plano = '{$Plano}'";
			
			if ($ModificarPDF == "1") 
				$strSQL.= ", PDF = '{$PDF}'";
			
			$strSQL.= " WHERE NumeTipo = {$NumeTipo}";
				
			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error al modificar f&aacute;brica:<br/>" . $result . "<br/>" . $strSQL;
			else 
				echo "Tipolog&iacute;a modificada!";
			break;

		case 2: //DELETE
			$strSQL = "SELECT Imagen, Portada, Plano FROM tipologias WHERE NumeTipo = " . $NumeTipo;
			$tabla = cargarTabla($strSQL);
			$fila = $tabla->fetch_array();
				
			if ($fila["Imagen"] != "")
				unlink("../" . $fila["Imagen"]);
			
			if ($fila["Portada"] != "")
				unlink("../" . $fila["Portada"]);
			
			if ($fila["Plano"] != "")
				unlink("../" . $fila["Plano"]);
			
			if (isset($tabla))
				$tabla->free();
			
			$strSQL = "DELETE FROM tipologias WHERE NumeTipo = " . $NumeTipo;
			
			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error al borrar tipolog&iacute;a:<br/>" . $result . "<br/>" . $strSQL;
			else
				echo "Tipolog&iacute;a borrada!";

			break;

		case 10: //LISTAR
			$strSQL = "SELECT t.NumeTipo, t.NombTipo, t.Subtitulo, t.Tipologia, t.Superficie, t.Opcionales, t.Imagen";
			$strSQL.= ", t.chkBano, t.chkGriferia, t.chkPinturaExt, t.chkPinturaInt, t.chkBacha, t.chkMesada, t.chkBajoMesada, t.chkAlacena, t.chkTanqueAgua, t.chkElectrico, t.Oferta, t.Premium";
			$strSQL.= ", t.Portada, t.Plano, t.NumeFabr, f.NombFabr, t.Precio, t.Entrega, t.CantHabi, t.Mayorista, t.Financiacion";
			$strSQL.= ", t.Porcentaje, t.CantCuotas";
			$strSQL.= " FROM tipologias t";
			$strSQL.= " INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
			if ($_SESSION['TipoUsua'] != "1") {
				$strSQL.= " WHERE f.NumeFabr = {$_SESSION["NumeFabr"]}";
			}
			$strSQL.= " ORDER BY t.NumeFabr, t.NombTipo";
			
			$tabla = cargarTabla($strSQL);
			
			$salida = '';
			
			if (mysqli_num_rows($tabla) > 0) {
				$salida.= $crlf.'<table class="table table-striped table-condensed">';
				$salida.= $crlf.'<tr>';
				$salida.= $crlf.'<th>Numero</th>';
				$salida.= $crlf.'<th>Nombre</th>';
				$salida.= $crlf.'<th>F&aacute;brica</th>';
				$salida.= $crlf.'<th style="text-align: center;">Galer&iacute;as</th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'</tr>';
					
				while ($fila = $tabla->fetch_array()) {
					$salida.= $crlf.'<tr>';
						
					//Numero
					$salida.= $crlf.'<td id="NumeTipo'.$fila[0].'">'.$fila[0];
						
					$salida.= $crlf.'<input type="hidden" id="Imagen'.$fila[0].'" value="'.$fila["Imagen"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Portada'.$fila[0].'" value="'.$fila["Portada"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Plano'.$fila[0].'" value="'.$fila["Plano"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Subtitulo'.$fila[0].'" value="'.$fila["Subtitulo"].'" />';
					$salida.= $crlf.'<input type="hidden" id="NumeFabr'.$fila[0].'" value="'.$fila["NumeFabr"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Tipologia'.$fila[0].'" value="'.$fila["Tipologia"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Superficie'.$fila[0].'" value="'.$fila["Superficie"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Opcionales'.$fila[0].'" value="'.$fila["Opcionales"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Precio'.$fila[0].'" value="'.$fila["Precio"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Entrega'.$fila[0].'" value="'.$fila["Entrega"].'" />';
					$salida.= $crlf.'<input type="hidden" id="CantHabi'.$fila[0].'" value="'.$fila["CantHabi"].'" />';

					$salida.= $crlf.'<input type="hidden" id="chkBano'.$fila[0].'" value="'.$fila["chkBano"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkGriferia'.$fila[0].'" value="'.$fila["chkGriferia"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkPinturaExt'.$fila[0].'" value="'.$fila["chkPinturaExt"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkPinturaInt'.$fila[0].'" value="'.$fila["chkPinturaInt"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkBacha'.$fila[0].'" value="'.$fila["chkBacha"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkMesada'.$fila[0].'" value="'.$fila["chkMesada"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkBajoMesada'.$fila[0].'" value="'.$fila["chkBajoMesada"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkAlacena'.$fila[0].'" value="'.$fila["chkAlacena"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkTanqueAgua'.$fila[0].'" value="'.$fila["chkTanqueAgua"].'" />';
					$salida.= $crlf.'<input type="hidden" id="chkElectrico'.$fila[0].'" value="'.$fila["chkElectrico"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Oferta'.$fila[0].'" value="'.$fila["Oferta"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Premium'.$fila[0].'" value="'.$fila["Premium"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Mayorista'.$fila[0].'" value="'.$fila["Mayorista"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Financiacion'.$fila[0].'" value="'.$fila["Financiacion"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Porcentaje'.$fila[0].'" value="'.$fila["Porcentaje"].'" />';
					$salida.= $crlf.'<input type="hidden" id="CantCuotas'.$fila[0].'" value="'.$fila["CantCuotas"].'" />';
						
					$salida.= $crlf.'</td>';
					//Nombre
					$salida.= $crlf.'<td id="NombTipo'.$fila[0].'">'.$fila["NombTipo"].'</td>';
					//Fabrica
					$salida.= $crlf.'<td>'.$fila["NombFabr"].'</td>';
					//Botones
					$salida.= $crlf.'<td style="text-align: center;">';
					$salida.= $crlf.'<input type="button" value="Im&aacute;genes" onclick="galeria('.$fila[0].', 1)" class="btn btn-default" />';
					$salida.= $crlf.'<input type="button" value="Renders" onclick="galeria('.$fila[0].', 2)" class="btn btn-default" />';
					$salida.= $crlf.'</td>';
					//Editar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Editar" onclick="editar(\''.$fila[0].'\')" class="btn btn-info" /></td>';
					//Borrar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Borrar" onclick="borrar(\''.$fila[0].'\')" class="btn btn-danger" /></td>';
						
					$salida.= $crlf.'</tr>';
				}
			
				$salida.= $crlf.'</table>';
			}
			else {
				$salida.= "<h3>Sin datos para mostrar</h3>";
			}
			$tabla->free();
			
			echo $salida;
	
	    	break;
	}
	
?>