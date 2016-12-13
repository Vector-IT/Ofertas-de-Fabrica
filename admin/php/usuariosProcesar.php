<?php
	session_start();
	if (!isset($_SESSION['is_logged_in'])) {
		header("Location:login.php");
		die();
	}

	include_once "conexion.php";
	
	$operacion = $_POST["operacion"];
	
	if (isset($_POST["NumeUsua"]))
		$NumeUsua = $_POST["NumeUsua"];
	
	if (isset($_POST["NombComp"]))
		$NombComp = str_replace("'", "\'", $_POST["NombComp"]);

	if (isset($_POST["NombMail"]))
		$NombMail = trim(str_replace("'", "\'", $_POST["NombMail"]));
	
	if (isset($_POST["NombUsua"]))
		$NombUsua = trim(str_replace("'", "\'", $_POST["NombUsua"]));
	
	if (isset($_POST["NombPass"]))
		$NombPass = str_replace("'", "\'", $_POST["NombPass"]);
	
	if (isset($_POST["NombPassNew"]))
		$NombPassNew = str_replace("'", "\'", $_POST["NombPassNew"]);
	
	if (isset($_POST["TipoUsua"]))
		$TipoUsua = $_POST["TipoUsua"];
	
	if (isset($_POST["NumeEsta"]))
		$NumeEsta = $_POST["NumeEsta"];
	
	if (isset($_POST["NumeFabr"]))
		$NumeFabr = $_POST["NumeFabr"];
	
	switch ($operacion) {
		case 0: //INSERT
			if ($TipoUsua != "4") {
				$usuario = buscarDato("SELECT NumeUsua FROM usuarios WHERE NombUsua = '{$NombUsua}'");
				if ($usuario != "") {
					echo "Error! Usuario ya registrado!";
					die();
				}
			}

			$usuario = buscarDato("SELECT NumeUsua FROM usuarios WHERE NombMail = '{$NombMail}'");
			if ($usuario != "") {
				echo "Error! Mail ya registrado!";
				die();
			}
				
			$NumeUsua = buscarDato("SELECT COALESCE(MAX(NumeUsua), 0) + 1 NumeUsua FROM usuarios");

			//INSERT
			$strSQL = "INSERT INTO usuarios(NumeUsua, NombComp, NombMail, NombUsua, NombPass, TipoUsua, NumeEsta, FechAlta, NumeFabr)";
			$strSQL.= " VALUES({$NumeUsua}, '{$NombComp}', '{$NombMail}', '{$NombUsua}', '{$NombPass}', {$TipoUsua}, {$NumeEsta}, SYSDATE(), {$NumeFabr})";
			
			$resultado = ejecutarCMD($strSQL);
			if (!$resultado)
				echo "Error al crear usuario";
			else 				
				echo "Usuario Creado!";

			break;

		case 1: //UPDATE
			$strSQL = "UPDATE usuarios";
			$strSQL.= " SET NombComp = '{$NombComp}'";
			$strSQL.= ", NombMail = '{$NombMail}'";
			$strSQL.= ", NombUsua = '{$NombUsua}'";
			if ($NombPass != "****")
				$strSQL.= ", NombPass = '{$NombPass}'";
			$strSQL.= ", TipoUsua = {$TipoUsua}";
			$strSQL.= ", NumeEsta = {$NumeEsta}";
			$strSQL.= ", NumeFabr = {$NumeFabr}";
			$strSQL.= " WHERE NumeUsua = " . $NumeUsua;

			
			$resultado = ejecutarCMD($strSQL);
			if (!$resultado)
				echo "Error al modificar usuario:<br />" . $resultado;
			else 
				echo "Usuario Modificado!";
			
			break;

		case 2: //DELETE
			$strSQL = "DELETE FROM usuarios WHERE NumeUsua = {$NumeUsua}";
			
			$resultado = ejecutarCMD($strSQL);
			if (!resultado)
				echo "Error al borrar usuario:<br />" . $resultado;
			else
				echo "Usuario borrado!";

			break;
		
		case 10: //LISTAR
			$strSQL = "SELECT u.NumeUsua, u.FechAlta, u.NombComp, u.NombMail, u.NombUsua, u.TipoUsua, u.NumeEsta,";
			$strSQL.= " u.NumeFabr, COALESCE(f.NombFabr, 'TODAS LAS FABRICAS') NombFabr";
			$strSQL.= " FROM usuarios u";
			$strSQL.= " LEFT JOIN fabricas f ON u.NumeFabr = f.NumeFabr";
			$strSQL.= " ORDER BY u.TipoUsua, u.NumeUsua";

			$tabla = cargarTabla($strSQL);

			$salida = '';

			if (mysqli_num_rows($tabla) > 0) {
				$salida.= $crlf.'<table class="table table-striped table-condensed">';
				$salida.= $crlf.'<tr>';
				$salida.= $crlf.'<th>N&uacute;mero</th>';
				$salida.= $crlf.'<th>Nombre</th>';
				$salida.= $crlf.'<th>Usuario</th>';
				$salida.= $crlf.'<th>Mail</th>';
				$salida.= $crlf.'<th>Tipo de usuario</th>';
				$salida.= $crlf.'<th>Fábrica</th>';
				$salida.= $crlf.'<th>Fecha de registro</th>';
				$salida.= $crlf.'<th>Estado</th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'<th></th>';
				$salida.= $crlf.'</tr>';
								 
	    		while ($fila = $tabla->fetch_array()) {
	    			$salida.= $crlf.'<tr>';
	    					 
					//Numero
					$salida.= $crlf.'<td id="NumeUsua'.$fila["NumeUsua"].'">'.$fila["NumeUsua"];
					$salida.= $crlf.'<input type="hidden" id="TipoUsua'.$fila["NumeUsua"].'" value="'.$fila["TipoUsua"].'" />';
					$salida.= $crlf.'<input type="hidden" id="NumeEsta'.$fila["NumeUsua"].'" value="'.$fila["NumeEsta"].'" />';
					$salida.= $crlf.'<input type="hidden" id="NombMail'.$fila["NumeUsua"].'" value="'.$fila["NombMail"].'" />';
					$salida.= $crlf.'<input type="hidden" id="NumeFabr'.$fila["NumeUsua"].'" value="'.$fila["NumeFabr"].'" />';
					$salida.= $crlf.'</td>';
					//Nombre
					$salida.= $crlf.'<td id="NombComp'.$fila["NumeUsua"].'">'.$fila["NombComp"].'</td>';
					//Usuario
					$salida.= $crlf.'<td id="NombUsua'.$fila["NumeUsua"].'">'.$fila["NombUsua"].'</td>';
					//Mail
					$salida.= $crlf.'<td>'.$fila["NombMail"].'</td>';
					//Tipo
					switch ($fila["TipoUsua"]) {
						case 1:
							$salida.= $crlf.'<td>Administrador</td>';
							break;
						case 2:
							$salida.= $crlf.'<td>F&aacute;brica</td>';
							break;
					}
					//Fabrica
					$salida.= $crlf.'<td>'.$fila["NombFabr"].'</td>';
					//Fecha alta
					$salida.= $crlf.'<td>'.$fila["FechAlta"].'</td>';
					//Estado
					if ($fila["NumeEsta"] == 1)
						$salida.= $crlf.'<td>Activo</td>';
					else
						$salida.= $crlf.'<td>Inactivo</td>';
					
					//Editar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Editar" onclick="editar(\''.$fila["NumeUsua"].'\')" class="btn btn-info" /></td>';
					//Borrar
					$salida.= $crlf.'<td style="text-align: center;"><input type="button" value="Borrar" onclick="borrar(\''.$fila["NumeUsua"].'\')" class="btn btn-danger" /></td>';
					
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