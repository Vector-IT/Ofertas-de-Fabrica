<?php
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])) {
		header("Location:login.php");
		die();
	}
	
	include("conexion.php");
	include("upload_file.php");
	
	$operacion = $_POST["operacion"];
	
	if (isset($_POST["NumeFabr"])) {
		$NumeFabr = $_POST["NumeFabr"];
	}
	
	if (isset($_POST["NombFabr"])) {
		$NombFabr = str_replace("'", "\'", $_POST["NombFabr"]);
	}

	if (isset($_POST["Dominio"])) {
		$Dominio = str_replace("'", "\'", $_POST["Dominio"]);
	}
	
	if (isset($_POST["Email"])) {
		$Email = str_replace("'", "\'", $_POST["Email"]);
	}

	if (isset($_POST["PrecioKm"])) {
		$PrecioKm = $_POST["PrecioKm"];
	}

	if (isset($_POST["LatLng"])) {
		$LatLng = $_POST["LatLng"];
	}

	if (isset($_POST["Descripcion"])) {
		$Descripcion = str_replace("'", "\'", $_POST["Descripcion"]);
	}
	
	if (isset($_POST["Telefono"])) {
		$Telefono = str_replace("'", "\'", $_POST["Telefono"]);
	}

	if (isset($_POST["Estado"])) {
		$chkEstado = $_POST["Estado"];
	}
	else {
		$chkEstado = 0;
	}
	
	switch ($operacion) {
		case 0: //INSERT
			$NumeFabr = buscarDato("SELECT COALESCE(MAX(NumeFabr), 0) + 1 Numero FROM fabricas");
			
			if (!empty($_FILES["Logo"])) {
				$temp = explode(".", $_FILES["Logo"]["name"]);
				$extension = end($temp);

				$archivo = $NumeFabr . "-Logo." . $extension;
				$Logo = "imgFabricas/" . $archivo;
				 
				subir_archivo($_FILES["Logo"], "../imgFabricas", $archivo);
			}
			
			if (!empty($_FILES["Menu"])) {
				$temp = explode(".", $_FILES["Menu"]["name"]);
				$extension = end($temp);
				
				$archivo = $NumeFabr . "-Menu." . $extension;
				$Menu = "imgFabricas/" . $archivo;
					
				subir_archivo($_FILES["Menu"], "../imgFabricas", $archivo);
			}
			
			if (!empty($_FILES["Portada"])) {
				$temp = explode(".", $_FILES["Portada"]["name"]);
				$extension = end($temp);
			
				$archivo = $NumeFabr . "-Portada." . $extension;
				$Portada = "imgFabricas/" . $archivo;
					
				subir_archivo($_FILES["Portada"], "../imgFabricas", $archivo);
			}
				
			$strSQL = "INSERT INTO fabricas(NumeFabr, NombFabr, Dominio, Email, Logo, Menu, Portada, Descripcion, PrecioKm, LatLng, Telefono, Estado)";
			$strSQL.= " VALUES({$NumeFabr}, '{$NombFabr}', '{$Dominio}', '{$Email}', '{$Logo}', '{$Menu}', '{$Portada}', '{$Descripcion}', '{$PrecioKm}', '{$LatLng}', '{$Telefono}', {$chkEstado})";

			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error al crear f&aacute;brica:<br/>" . $result . "<br/>" . $strSQL;
			else 
				echo "F&aacute;brica Creada!<br>";

			break;

		case 1: //UPDATE
			$strSQL = "SELECT Logo, Menu, Portada FROM fabricas WHERE NumeFabr = " . $NumeFabr;
			$tabla = cargarTabla($strSQL);
			$fila = $tabla->fetch_array();
			$tabla->free();
			
			if (!empty($_FILES["Logo"])) {
				unlink("../" . $fila["Logo"]);
				
				$temp = explode(".", $_FILES["Logo"]["name"]);
				$extension = end($temp);

				$archivo = $NumeFabr . "-Logo." . $extension;
				$Logo = "imgFabricas/" . $archivo;
				 
				subir_archivo($_FILES["Logo"], "../imgFabricas", $archivo);
			}
			
			if (!empty($_FILES["Menu"])) {
				unlink("../" . $fila["Menu"]);
			
				$temp = explode(".", $_FILES["Menu"]["name"]);
				$extension = end($temp);
			
				$archivo = $NumeFabr . "-Menu." . $extension;
				$Menu = "imgFabricas/" . $archivo;
					
				subir_archivo($_FILES["Menu"], "../imgFabricas", $archivo);
			}
			
			if (!empty($_FILES["Portada"])) {
				unlink("../" . $fila["Portada"]);
			
				$temp = explode(".", $_FILES["Portada"]["name"]);
				$extension = end($temp);
			
				$archivo = $NumeFabr . "-Portada." . $extension;
				$Portada = "imgFabricas/" . $archivo;
					
				subir_archivo($_FILES["Portada"], "../imgFabricas", $archivo);
			}
			
			$strSQL = "UPDATE fabricas";
			$strSQL.= " SET NombFabr = '{$NombFabr}'";
			$strSQL.= ", Dominio = '{$Dominio}'";
			$strSQL.= ", Email = '{$Email}'";
			$strSQL.= ", PrecioKm = '{$PrecioKm}'";
			$strSQL.= ", LatLng = '{$LatLng}'";
			$strSQL.= ", Descripcion = '{$Descripcion}'";
			$strSQL.= ", Telefono = '{$Telefono}'";
			$strSQL.= ", Estado = {$chkEstado}";
			
			if (!empty($_FILES["Logo"])) 
				$strSQL.= ", Logo = '{$Logo}'";
		
			if (!empty($_FILES["Menu"]))
				$strSQL.= ", Menu = '{$Menu}'";
			
			if (!empty($_FILES["Portada"]))
				$strSQL.= ", Portada = '{$Portada}'";
			
			$strSQL.= " WHERE NumeFabr = " . $NumeFabr;
			
			$result = ejecutarCMD($strSQL);
			
			if (!$result)
				echo "Error al modificar f&aacute;brica:<br/>" . $result . "<br/>" . $strSQL;
			else 
				echo "F&aacute;brica modificada!";
			break;

		case 2: //DELETE
			$cantTipo = buscarDato("SELECT COUNT(*) FROM tipologias WHERE NumeFabr = " . $NumeFabr);
			
			if ($cantTipo == 0) {
				$strSQL = "SELECT Logo, Portada FROM fabricas WHERE NumeFabr = " . $NumeFabr;
				$tabla = cargarTabla($strSQL);
				$fila = $tabla->fetch_array();
					
				if ($fila["Logo"] != "")
					unlink("../" . $fila["Logo"]);
				
				if ($fila["Portada"] != "")
					unlink("../" . $fila["Portada"]);
				
				if (isset($tabla))
					$tabla->free();
				
				$strSQL = "DELETE FROM fabricas WHERE NumeFabr = " . $NumeFabr;
				
				$result = ejecutarCMD($strSQL);
				
				if (!$result)
					echo "Error al borrar f&aacute;brica:<br/>" . $result . "<br />" . $strSQL;
				else
					echo "F&aacute;brica borrada!";
			}
			else
				echo "Esta F&aacute;brica posee tipolog&iacute;as cargadas!<br/>Eliminelas antes.";
			
			break;

		case 10: //LISTAR
			$strSQL = "SELECT NumeFabr, NombFabr, Dominio, Email, Logo, Menu, Portada, Descripcion,";
			$strSQL.= " PrecioKm, LatLng, Telefono, Estado";
			$strSQL.= " FROM fabricas";
			$strSQL.= " ORDER BY NumeFabr";

			$tabla = cargarTabla($strSQL);

			$salida = '';

			if (mysqli_num_rows($tabla) > 0) {
				$salida.= $crlf.'<table class="table table-striped table-condensed">';
				$salida.= $crlf.'<tr>';
				$salida.= $crlf.'<th>Numero</th>';
				$salida.= $crlf.'<th>Nombre</th>';
				$salida.= $crlf.'<th>Logo</th>';
				$salida.= $crlf.'<th>Dominio</th>';
				$salida.= $crlf.'<th>E-Mail</th>';
				$salida.= $crlf.'<th>Estado</th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'</tr>';
								 
	    		while ($fila = $tabla->fetch_array()) {
    				$salida.= $crlf.'<tr>';
	    					 
					//Numero
					$salida.= $crlf.'<td id="NumeFabr'.$fila[0].'">'.$fila["NumeFabr"];
					
					$salida.= $crlf.'<input type="hidden" id="Logo'.$fila[0].'" value="'.$fila["Logo"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Menu'.$fila[0].'" value="'.$fila["Menu"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Portada'.$fila[0].'" value="'.$fila["Portada"].'" />';
					$salida.= $crlf.'<input type="hidden" id="PrecioKm'.$fila[0].'" value="'.$fila["PrecioKm"].'" />';
					$salida.= $crlf.'<input type="hidden" id="LatLng'.$fila[0].'" value="'.$fila["LatLng"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Telefono'.$fila[0].'" value="'.$fila["Telefono"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Estado'.$fila[0].'" value="'.$fila["Estado"].'" />';
					$salida.= $crlf.'<input type="hidden" id="Descripcion'.$fila[0].'" value="'.str_replace("\"", "&quot;", $fila["Descripcion"]).'" />';
					
					$salida.= $crlf.'</td>';
					//Nombre
					$salida.= $crlf.'<td id="NombFabr'.$fila[0].'">'.$fila["NombFabr"].'</td>';
					//Logo
					$salida.= $crlf.'<td><img src="'.$fila["Logo"].'" style="width: 100px; height: auto;" /></td>';
					//Dominio
					$salida.= $crlf.'<td id="Dominio'.$fila[0].'">'.$fila["Dominio"].'</td>';
					//E-Mail
					$salida.= $crlf.'<td id="Email'.$fila[0].'">'.$fila["Email"].'</td>';
					//Estado
					if ($fila["Estado"] == "1")
						$salida.= $crlf.'<td>ACTIVA</td>';
					else
						$salida.= $crlf.'<td>INACTIVA</td>';
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