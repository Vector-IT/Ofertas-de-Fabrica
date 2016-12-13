<?php 
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])){
		header("Location:login.php");
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'php/linkshead.php'; ?>
</head>
<body>
	<?php
		include_once 'php/menu.php';
	?>
	
	<div class="container">
		<div class="page-header">
			<h2>Consola de Administraci&oacute;n</h2>
		</div>
		
		<p class="lead">
			Bienvenido a la consola de administraci&oacute;n de Ofertas de F&aacute;brica<br>
			Utilice el men&uacute; situado en el margen izquierdo de la pantalla para acceder a las distintas 
			secciones del sistema.			
		</p>
	</div>	
</body>
</html>