<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include("conexion.php");
	
	$user = strtoupper(str_replace("'", "", $_POST["usuario"]));
	$pass = strtoupper(str_replace("'", "", $_POST["password"]));
	
	$tabla = cargarTabla("SELECT NumeUsua, NombComp, TipoUsua, NumeFabr FROM usuarios WHERE NumeEsta = 1 AND TipoUsua IN (1, 2) AND NombUsua = '{$user}' AND NombPass = '{$pass}'");
	
	$strSalida = "";
	
	if ($tabla->num_rows > 0)
	{
		session_start();
		$fila = $tabla->fetch_array();
		$_SESSION['is_logged_in'] = 1;
		$_SESSION['NumeUsua'] = $fila['NumeUsua'];
		$_SESSION['NombUsua'] = $fila['NombComp'];
		$_SESSION['TipoUsua'] = $fila["TipoUsua"];
		$_SESSION['NumeFabr'] = $fila["NumeFabr"];
	
		$tabla->free();
	}
	else {
		//Error
		if ($_POST["returnUrl"] == "-1") {
			echo "ERROR";
		}
		else {
			header("Location:../login.php?error=1");
			die();
		}
	}
}

if ($_POST["returnUrl"] == "-1") {
	echo "Ok";
}
else if ($_POST["returnUrl"] == "")
	header("Location:../index.php");
else
	header("Location:".$_POST["returnUrl"]);
//die();

?>
