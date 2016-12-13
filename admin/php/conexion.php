<?php 
	$dbhost = "192.168.1.100";
	$db = "ddefabrica";
	$dbuser = "ddefabrica";
	$dbpass = "vector";
	$crlf = "\n";
	$raiz = "/Directo de Fabrica/";
	
	function ejecutarCMD($strSQL) {
		global $dbhost, $dbuser, $dbpass, $db, $crlf;
		
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
		$conn->set_charset("utf8");
	
		$strError = "";
	
		if (!$conn->query($strSQL))
			$strError = $conn->error;
		$conn->close();
	
		if ($strError == "")
			return true;
		else
			return $strError;
	}

	function buscarDato($strSQL) {
		global $dbhost, $dbuser, $dbpass, $db, $crlf;
		
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
		$conn->set_charset("utf8");
	
		$strSalida = "";
	
		if (!($tabla = $conn->query($strSQL))) {
			$strSalida = "Error al realizar la consulta.";
		}
		else {
			$fila = $tabla->fetch_array();
			$strSalida = $fila[0];
			$tabla->free();
		}
	
		$conn->close();
		 
		return $strSalida;
	}
	
	function cargarTabla($strSQL) {
		global $dbhost, $dbuser, $dbpass, $db, $crlf;
		
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
		$conn->set_charset("utf8");
		
		$tabla = $conn->query($strSQL);
		
		$conn->close();
		
		return $tabla;
	}
	
	function cargarCombo($strSQL, $CampoNumero, $CampoTexto, $Seleccion = "", $itBlank = false) {
		global $dbhost, $dbuser, $dbpass, $db, $crlf;
		
		$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
		$conn->set_charset("utf8");
		
		$tabla = $conn->query($strSQL);
		
		$conn->close();
		
		$strSalida = "";
		if ($itBlank)
			$strSalida.= $crlf.'<option value="-1">Seleccione...</option>';
		
		while ($fila = $tabla->fetch_array()) {
			if ($CampoTexto != "") {
				if (strcmp($fila[$CampoNumero], $Seleccion) != "0")
					$strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'">'.htmlentities($fila[$CampoTexto]).'</option>';
				else
					$strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" selected>'.htmlentities($fila[$CampoTexto]).'</option>';
			}
			else {
				if (strcmp($fila[$CampoNumero], $Seleccion) != "0")
					$strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" />';
				else
					$strSalida.= $crlf.'<option value="'.$fila[$CampoNumero].'" selected />';
			}
		}
		
		return $strSalida;
	}
	
	function get_random_string($valid_chars, $length)
	{
		// start with an empty random string
		$random_string = "";
	
		// count the number of chars in the valid chars string so we know how many choices we have
		$num_valid_chars = strlen($valid_chars);
	
		// repeat the steps until we've created a string of the right length
		for ($i = 0; $i < $length; $i++)
		{
			// pick a random number from 1 up to the number of valid chars
			$random_pick = mt_rand(1, $num_valid_chars);
	
			// take the random character out of the string of valid chars
			// subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
			$random_char = $valid_chars[$random_pick-1];
	
			// add the randomly-chosen char onto the end of our string so far
			$random_string .= $random_char;
		}
	
		// return our finished random string
		return $random_string;
	}
	
	function procesarRuteo() {
		$archivo = "../../.htaccess";
		
		global $raiz;
	
		$contenido = "<IfModule mod_rewrite.c>";
		$contenido.= "\nRewriteEngine On";
		$contenido.= "\nRewriteBase " . $raiz;
		$contenido.= "\nRewriteRule ^fabrica/([^/]+)/([^/]+)/? {$raiz}tipologia.php?fabrica=$1&tipologia=$2 [L,PT]";
		$contenido.= "\nRewriteRule ^fabrica/([^/]*)/? {$raiz}fabrica.php?fabrica=$1 [L,PT]";
		$contenido.= "\nRewriteRule ^blog/([^/]*)/? {$raiz}blog.php?blog=$1 [L,PT]";
		
		$contenido.= "\n";
		$contenido.= "\nRewriteCond %{REQUEST_URI}  !\.(css|js|php|html?|shtml|jpg|JPG|gif|png|jpeg|eot|otf|svg|ttf|woff|woff2|pdf)$";
		$contenido.= "\nRewriteRule ^(.*)([^/])$ http://%{HTTP_HOST}/$1$2/ [L,R=301]";
		$contenido.= "\n</IfModule>";
	
		file_put_contents($archivo, $contenido);
	}
	
?>