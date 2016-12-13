<?php 
	include_once 'php/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'php/linkshead.php'; ?>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#usuario").focus();
		});
	</script>
<body>
	<div class="jumbotron">
		<div class="container">
			<img alt="logo" src="img/logo2.png" style="width: 210px; height: auto;" >
		</div>
	</div>	
	
	<div class="container">
		<div class="page-header">
			<h2>Acceda al sistema</h2>
		</div>
			
		<form action="php/loginProcesar.php" method="post" class="form-horizontal">
			<?php
				if (isset($_REQUEST["error"])) {
					$strSalida = '';
					$strSalida.= '<div class="alert alert-danger alert-dismissible" role="alert">';
					$strSalida.= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					$strSalida.= '<strong>Error!</strong> El usuario o la contrase&ntilde;a son incorrectos.';
					$strSalida.= '</div>';
					
					echo $strSalida;
				}
				
				if (isset($_REQUEST["returnUrl"])) 
					echo '<input type="hidden" name="returnUrl" value="'.$_REQUEST["returnUrl"].'" />';
				else
					echo '<input type="hidden" name="returnUrl" value="../index.php" />';
			?>
			
			<div class="form-group">
				<label for="usuario" class="control-label col-md-2">Usuario:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required />
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="control-label col-md-2">Contrase&ntilde;a:</label>
				<div class="col-md-4">
					<input type="password" class="form-control" name="password" placeholder="Contrase&ntilde;a" required />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-4">
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</div>
		</form>
		
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-default" onclick="location.href = '<?php echo $raiz?>';">Ir al Sitio</button>
			</div>
		</div>
	</div>
</body>
</html>