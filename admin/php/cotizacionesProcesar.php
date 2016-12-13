<?php
	session_start();
	
	include("conexion.php");
	
	$operacion = $_POST["operacion"];
	
	if (isset($_POST["NumeCoti"])) {
		$NumeCoti = $_POST["NumeCoti"];
	}
	
	if (isset($_POST["NumeTipo"])) {
		$NumeTipo = $_POST["NumeTipo"];
	}
	
	if (isset($_POST["TipoCoti"])) {
		$TipoCoti = $_POST["TipoCoti"];
	}
	
	if (isset($_POST["NumeEsta"])) {
		$NumeEsta = $_POST["NumeEsta"];
	}
	
	if (isset($_POST["Nombre"])) {
		$Nombre = str_replace("'", "\'", $_POST["Nombre"]);
	}
	
	if (isset($_POST["Telefono"])) {
		$Telefono = str_replace("'", "\'", $_POST["Telefono"]);
	}
	
	if (isset($_POST["Email"])) {
		$Email = str_replace("'", "\'", $_POST["Email"]);
	}
	
	if (isset($_POST["Adicionales"])) {
		$Adicionales = str_replace("'", "\'", $_POST["Adicionales"]);
	}
	
	if (isset($_POST["Precio"])) {
		$Precio = str_replace("'", "\'", $_POST["Precio"]);
	}
	
	if (isset($_POST["Entrega"]) && $_POST["Entrega"] != "") {
		$Entrega = str_replace("'", "\'", $_POST["Entrega"]);
	}
	else
		$Entrega = "0";
	
	if (isset($_POST["Porcentaje"]) && $_POST["Porcentaje"] != "") {
		$Porcentaje = str_replace("'", "\'", $_POST["Porcentaje"]);
	}
	else
		$Porcentaje = "0";
	
	if (isset($_POST["CantCuotas"]) && $_POST["CantCuotas"] != "") {
		$CantCuotas = str_replace("'", "\'", $_POST["CantCuotas"]);
	}
	else 
		$CantCuotas = "0";
	
	if (isset($_POST["MontoCuota"]) && $_POST["MontoCuota"] != "") {
		$MontoCuota = str_replace("'", "\'", $_POST["MontoCuota"]);
	}
	else
		$MontoCuota = "0";
	
	if (isset($_POST["LatLng"]) && $_POST["LatLng"] != "") {
		$LatLng = str_replace("'", "\'", $_POST["LatLng"]);
	}
	else
		$LatLng = "";
	
	if (isset($_POST["Distancia"]) && $_POST["Distancia"] != "") {
		$Distancia = str_replace("'", "\'", $_POST["Distancia"]);
	}
	else
		$Distancia = "";
	
	if (isset($_POST["Dispone"]) && $_POST["Dispone"] != "") {
		$Dispone = $_POST["Dispone"];
	}
	else
		$Dispone = "";
	
	if (isset($_POST["HoraCont"]) && $_POST["HoraCont"] != "") {
		$HoraCont = $_POST["HoraCont"];
	}
	else
		$HoraCont = "";
	
	switch ($operacion) {
		case 0: //INSERT
			$NumeCoti = buscarDato("SELECT COALESCE(MAX(NumeCoti), 0) + 1 Numero FROM cotizaciones");
			
			$strSQL = "INSERT INTO cotizaciones(NumeCoti, NumeTipo, TipoCoti, FechCoti, NumeEsta, Nombre, Telefono, Email, Adicionales, Precio, Entrega, Porcentaje, CantCuotas, MontoCuota, LatLng, Distancia, Dispone, HoraCont)";
			$strSQL.= " VALUES({$NumeCoti}, {$NumeTipo}, {$TipoCoti}, SYSDATE(), 1, '{$Nombre}', '{$Telefono}', '{$Email}', '{$Adicionales}', {$Precio}, {$Entrega}, {$Porcentaje}, {$CantCuotas}, {$MontoCuota}, '{$LatLng}', '{$Distancia}', '{$Dispone}', '{$HoraCont}')";

			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error";
			else 
				echo "EXITO-{$NumeCoti}";

			break;

		case 1: //UPDATE
			$strSQL = "UPDATE cotizaciones";
			$strSQL.= " SET NumeTipo = {$NumeTipo}";
			$strSQL.= ", TipoCoti = {$TipoCoti}";
			$strSQL.= ", NumeEsta = {$NumeEsta}";
			//$strSQL.= ", Nombre = '{$Nombre}'";
			//$strSQL.= ", Telefono = '{$Telefono}'";
			//$strSQL.= ", Email = '{$Email}'";
			$strSQL.= ", Adicionales = '{$Adicionales}'";
			$strSQL.= ", Precio = {$Precio}";
			$strSQL.= ", Entrega = {$Entrega}";
			$strSQL.= ", Porcentaje = {$Porcentaje}";
			$strSQL.= ", CantCuotas = {$CantCuotas}";
			$strSQL.= ", MontoCuota = {$MontoCuota}";
			$strSQL.= ", LatLng = '{$LatLng}'";
			$strSQL.= ", Distancia = '{$Distancia}'";
			$strSQL.= " WHERE NumeCoti = " . $NumeCoti;
			
			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error";
			else 
				echo "EXITO";
			break;

		case 2: //DELETE
			$strSQL = "DELETE FROM cotizaciones WHERE NumeCoti = " . $NumeCoti;
				
			$result = ejecutarCMD($strSQL);
				
			if (!$result)
				echo "Error";
			else
				echo "EXITO";
			break;

		case 10: //LISTAR
			$strSQL = "SELECT c.NumeCoti, c.NumeTipo, t.NombFabr, t.NombTipo, c.TipoCoti, c.FechCoti,";
			$strSQL.= " c.NumeEsta, c.Nombre, c.Telefono, c.Email, c.Adicionales, c.Precio, c.Entrega,";
			$strSQL.= " c.Porcentaje, c.CantCuotas, c.MontoCuota, c.LatLng, c.Distancia, c.Dispone, c.HoraCont";
			$strSQL.= " FROM cotizaciones c";
			$strSQL.= " INNER JOIN (SELECT t.NumeTipo, t.NombTipo, f.NombFabr";
			$strSQL.= "				FROM tipologias t";
			$strSQL.= "				INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
			if ($_SESSION['TipoUsua'] != "1") {
				$strSQL.= " WHERE f.NumeFabr = {$_SESSION["NumeFabr"]}";
			}			
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
				$salida.= $crlf.'<th>Tipo de cotizaci&oacute;n</th>';
				$salida.= $crlf.'<th>Distancia</th>';
				$salida.= $crlf.'<th>Datos</th>';
				$salida.= $crlf.'<th>Dispone</th>';
				$salida.= $crlf.'<th>Hora de Contacto</th>';
				$salida.= $crlf.'<th>Estado</th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'</tr>';
								 
	    		while ($fila = $tabla->fetch_array()) {
    				$salida.= $crlf.'<tr>';
	    					 
					//Numero
					$salida.= $crlf.'<td id="NumeCoti'.$fila[0].'">'.$fila[0];
					
					$salida.= $crlf.'<input type="hidden" id="NumeTipo'.$fila[0].'" value="'.$fila["NumeTipo"].'" />';
					$salida.= $crlf.'<input type="hidden" id="TipoCoti'.$fila[0].'" value="'.$fila["TipoCoti"].'" />';
					$salida.= $crlf.'<input type="hidden" id="NumeEsta'.$fila[0].'" value="'.$fila["NumeEsta"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Adicionales'.$fila[0].'" value="'.$fila["Adicionales"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Precio'.$fila[0].'" value="'.$fila["Precio"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Entrega'.$fila[0].'" value="'.$fila["Entrega"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Porcentaje'.$fila[0].'" value="'.$fila["Porcentaje"].'" />';
					$salida.= $crlf.'<input type="hidden" id="CantCuotas'.$fila[0].'" value="'.$fila["CantCuotas"].'" />';
					$salida.= $crlf.'<input type="hidden" id="MontoCuota'.$fila[0].'" value="'.$fila["MontoCuota"].'" />';
					$salida.= $crlf.'<input type="hidden" id="LatLng'.$fila[0].'" value="'.$fila["LatLng"].'" />';
					
					$salida.= $crlf.'</td>';
					
					//Fecha
					$salida.= $crlf.'<td id="FechCoti'.$fila[0].'">'.$fila["FechCoti"].'</td>';
					
					//Fabrica
					$salida.= $crlf.'<td>'.$fila["NombFabr"].'</td>';
					//Tipologia
					$salida.= $crlf.'<td>'.$fila["NombTipo"].'</td>';
					//Tipo de cotización
					if ($fila["TipoCoti"] == "1")
						$salida.= $crlf.'<td>Venta directa</td>';
					else
						$salida.= $crlf.'<td>Financiaci&oacute;n</td>';
					//Distancia
					$salida.= $crlf.'<td>'.$fila["Distancia"].'<br>';
					//Datos
					$salida.= $crlf.'<td>'.$fila["Nombre"].'<br>';
					$salida.= $crlf.$fila["Telefono"].'<br>';
					$salida.= $crlf.$fila["Email"].'</td>';
					
					//Dispone de
					$salida.= $crlf.'<td>'.$fila["Dispone"].'</td>';
					
					//Hora de contacto
					$salida.= $crlf.'<td>'.$fila["HoraCont"].'</td>';
					
					//Estado
					if ($fila["NumeEsta"] == "0")
						$salida.= $crlf.'<td>Inactiva</td>';
					elseif ($fila["NumeEsta"] == "1")
						$salida.= $crlf.'<td>Activa</td>';
					elseif ($fila["NumeEsta"] == "2")
						$salida.= $crlf.'<td>Procesada</td>';
					
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