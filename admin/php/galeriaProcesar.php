<?php
	include_once "conexion.php";
	include "upload_file.php";
	
	$operacion = $_POST["operacion"];
	$tipo = $_POST["tipo"];
	
	if (isset($_POST["NumeImag"])) {
		$NumeImag = $_POST["NumeImag"];
	}
	
	if (isset($_POST["NumeTipo"])) {
		$NumeTipo = $_POST["NumeTipo"];
	}
	
	if (isset($_POST["NumeOrde"])) {
		$NumeOrde = $_POST["NumeOrde"];
	}
	
	switch ($operacion) {
		case 0: //INSERT
			$NumeImag = buscarDato("SELECT COALESCE(MAX(NumeImag), 0) + 1 FROM tipologiasimagenes");
			$NumeOrde = buscarDato("SELECT COALESCE(MAX(NumeOrde), 0) + 1 FROM tipologiasimagenes WHERE Tipo = {$tipo} AND NumeTipo = " . $NumeTipo);
			
			if (!empty($_FILES["Imagen"])) {
				$temp = explode(".", $_FILES["Imagen"]["name"]);
				$extension = end($temp);
					
				if ($tipo == 1)
					$archivo = $NumeTipo . " galeria " . $NumeImag . "." . $extension;
				else
					$archivo = $NumeTipo . " render " . $NumeImag . "." . $extension;
				
				$Imagen = "imgTipologias/galerias/" . $archivo;
					
				subir_archivo($_FILES["Imagen"], "../imgTipologias/galerias", $archivo);
					
				$strSQL = "INSERT INTO tipologiasimagenes(NumeImag, Tipo, NumeTipo, NumeOrde, Imagen)";
				$strSQL.= " VALUES({$NumeImag}, {$tipo}, {$NumeTipo}, {$NumeOrde}, '{$Imagen}')";
				
				$result = ejecutarCMD($strSQL);
				if (!$result)
					echo "Error al crear imagen:<br/>" . $result . "<br/>" . $strSQL;
				else
					echo "Imagen Creada!<br>";
			}
			else
				echo "Error! Falta imagen";
			
			break;

		case 1: //UPDATE
			if (!empty($_FILES["Imagen"])) {
				$imgOld = buscarDato("SELECT Imagen FROM tipologiasimagenes WHERE NumeImag = " . $NumeImag);
				
				unlink("../" . $imgOld);
				
				$temp = explode(".", $_FILES["Imagen"]["name"]);
				$extension = end($temp);

				if ($tipo == 1)
					$archivo = $NumeTipo . " galeria " . $NumeImag . "." . $extension;
				else
					$archivo = $NumeTipo . " render " . $NumeImag . "." . $extension;
				
				$Imagen = "imgTipologias/galerias/" . $archivo;
				 
				subir_archivo($_FILES["Imagen"], "../imgTipologias/galerias", $archivo);
				
				$strSQL.= "UPDATE tipologiasimagenes";
				$strSQL.= " SET Imagen = '{$Imagen}'";
				$strSQL.= " WHERE NumeImag = " . $NumeImag;
					
				$result = ejecutarCMD($strSQL);
				if (!$result)
					echo "Error al modificar imagen:<br/>" . $result . "<br/>" . $strSQL;
				else
					echo "Imagen modificada!";
			}
			
			break;

		case 2: //DELETE
			$Imagen = buscarDato("SELECT Imagen FROM tipologiasimagenes WHERE NumeImag = " . $NumeImag);
			unlink("../" . $Imagen);
			
			$strSQL = "DELETE FROM tipologiasimagenes WHERE NumeImag = " . $NumeImag;
			
			$result = ejecutarCMD($strSQL);
			if (!$result)
				echo "Error al borrar imagen:<br/>" . $result . "<br/>" . $strSQL;
			else
				echo "Imagen borrada!";

			break;
		
		case 3: //SUBIR ORDEN
		case 4:
			$strSQL = "SELECT NumeImag";
			$strSQL.= " FROM tipologiasimagenes";
			$strSQL.= " WHERE NumeTipo = " . $NumeTipo;
			$strSQL.= " AND Tipo = " . $tipo;
			$strSQL.= " AND NumeOrde = " . $NumeOrde;
			
			$NumeImagOld = buscarDato($strSQL);

			if ($operacion == 3) {
				//Bajo la imagen anterior
				ejecutarCMD("UPDATE tipologiasimagenes SET NumeOrde = " . ($NumeOrde + 1) . " WHERE NumeImag = " . $NumeImagOld);
			}
			else {
				//Subo la imagen anterior
				ejecutarCMD("UPDATE tipologiasimagenes SET NumeOrde = " . ($NumeOrde - 1) . " WHERE NumeImag = " . $NumeImagOld);
			}
			
			//Subo la imagen actual
			ejecutarCMD("UPDATE tipologiasimagenes SET NumeOrde = {$NumeOrde} WHERE NumeImag = " . $NumeImag);
			
			echo "Imagen modificada!";
			break;
			
		case 10: //LISTAR
			$strSQL = "SELECT NumeImag, NumeOrde, Imagen";
			$strSQL.= " FROM tipologiasimagenes";
			$strSQL.= " WHERE NumeTipo = " . $NumeTipo;
			$strSQL.= " AND Tipo = " . $tipo;
			$strSQL.= " ORDER BY NumeOrde";

			$tabla = cargarTabla($strSQL);

			$salida = '';

			if ($tabla->num_rows > 0) {
				$salida.= $crlf.'<table class="table table-striped table-condensed">';
				$salida.= $crlf.'<tr>';
				$salida.= $crlf.'<th>Numero</th>';
				$salida.= $crlf.'<th>Imagen</th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'</tr>';
								 
	    		while ($fila = $tabla->fetch_array()) {
    				$salida.= $crlf.'<tr class="imagProp">';
	    					 
					//Numero
					$salida.= $crlf.'<td id="NumeOrde'.$fila[0].'">'.$fila["NumeOrde"].'</td>';
					//Imagen
					$salida.= $crlf.'<td><img class="thumbs" id="Imagen'.$fila[0].'" src="'.$fila["Imagen"].'" style="width: 100px; height: auto;" /></td>';
					
					//Subir
					$salida.= $crlf.'<td style="text-align: center;"><button type="button" title="Subir" class="btn btn-default" onclick="subir('.$fila[0].');"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></button></td>';
					//Bajar
					$salida.= $crlf.'<td style="text-align: center;"><button type="button" title="Bajar" class="btn btn-default" onclick="bajar('.$fila[0].');"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></button></td>';
					
					//Editar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Editar" data-id="'.$fila[0].'" onclick="editar('.$fila[0].');" class="btnEditar btn btn-info" /></td>';
					//Borrar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Borrar" data-id="'.$fila[0].'" onclick="borrar('.$fila[0].');" class="btnBorrar btn btn-danger" /></td>';
					
					$salida.= $crlf.'</tr>';
				}
				
				$salida.= $crlf.'</table>';
				
				$tabla->free();
	    	}
	    	else {
	    		$salida.= "<h3>Sin datos para mostrar</h3>";
	    	}
	    	
	    	echo $salida;
	
	    	break;
	}
?>