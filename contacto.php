<?php 
	session_start();
	include_once 'admin/php/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Contacto</title>
	
	<?php include_once 'php/linksHead.php';?>
	<script src="<?php echo $raiz;?>js/jquery.ns-autogrow.min.js"></script>
	<script src="<?php echo $raiz;?>js/contacto.js"></script>
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<div class="container-fluid">
		<div class="row">
			<h1>Ponte en contacto con nosotros</h1>
		</div>
		<div class="row marginTop40">
			<div class="col-md-8">
				<form id="consulta-form" method="post" data-dialog="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="nombre">Nombre y Apellido:</label>
								<input type="text" class="form-control" id="nombre" required />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="telefono">Tel&eacute;fono:</label>
								<input type="text" class="form-control" id="telefono" required />
							</div>			
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">E-mail:</label>
								<input type="email" class="form-control" id="email" required />
							</div>			
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="tipocoti">Forma de pago:</label>
								<select id="tipocoti" class="form-control">
									<option>Venta Directa</option>
									<option>Financiaci&oacute;n</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="entrega">Monto que dispone para entrega inicial:</label>
								<input type="text" class="form-control" id="entrega" required />
							</div>			
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="cuota">Monto estimado de cuota que puede abonar:</label>
								<input type="text" class="form-control" id="cuota" required />
							</div>			
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="dispone">Dispone de:</label>
								<select class="form-control" id="dispone" required>
									<option>NADA</option>
									<option>AUTO USADO</option>
									<option>ANTICIPO</option>
									<option>TERRENO</option>
									<option>PROPIEDAD</option>
								</select>
							</div>			
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="horadesde">Horario de contacto:</label>
								<select class="form-control" id="horadesde" required>
									<option selected="selected">09 hs</option>
									<option>10 hs</option>
									<option>11 hs</option>
									<option>12 hs</option>
									<option>13 hs</option>
									<option>14 hs</option>
									<option>15 hs</option>
									<option>16 hs</option>
									<option>17 hs</option>
									<option>18 hs</option>
									<option>19 hs</option>
									<option>20 hs</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<select class="form-control" id="horahasta" style="margin-top:25px;" required>
									<option>09 hs</option>
									<option>10 hs</option>
									<option>11 hs</option>
									<option>12 hs</option>
									<option>13 hs</option>
									<option>14 hs</option>
									<option>15 hs</option>
									<option>16 hs</option>
									<option>17 hs</option>
									<option>18 hs</option>
									<option>19 hs</option>
									<option selected="selected">20 hs</option>
								</select>
							</div>			
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="provincia">Provincia:</label>
								<select class="form-control" id="provincia" required>
									<option>Capital Federal</option>
									<option>Buenos Aires</option>
									<option>Catamarca</option>
									<option>Córdoba</option>
									<option>Corrientes</option>
									<option>Chaco</option>
									<option>Chubut</option>
									<option>Entre Ríos</option>
									<option>Formosa</option>
									<option>Jujuy</option>
									<option>La Pampa</option>
									<option>La Rioja</option>
									<option>Mendoza</option>
									<option>Misiones</option>
									<option>Neuquén</option>
									<option>Río Negro</option>
									<option>Salta</option>
									<option>San Juan</option>
									<option>San Luis</option>
									<option>Santa Cruz</option>
									<option>Santa Fe</option>
									<option>Santiago del Estero</option>
									<option>Tierra del Fuego</option>
									<option>Tucumán</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="ciudad">Ciudad:</label>
								<input type="text" class="form-control" id="ciudad" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="g-recaptcha" data-sitekey="6LdJMQ4UAAAAAPAVEp8vOCD0HAFKuT4Af4qZde7R"></div>
						</div>
					</div>
					
					<div class="row">
						<div id="divMsjConsulta" class="divMsj alert alert-danger" role="alert">
							<span id="txtHint"></span>
						</div>
					</div>
					
					<div class="form-group" id="divBotones">
						<div class="txtRight">
							<button type="submit" class="btn btn-danger">Enviar</button>
						</div>
					</div>
				</form>
				<!-- 
				<form class="form-horizontal" id="contacto-form" data-dialog="">
					<div class="form-group">
						<label for="nombre" class="control-label col-md-2">Nombre:</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="nombre" required />
						</div>
					</div>
					<div class="form-group">
						<label for="apellido" class="control-label col-md-2">Apellido:</label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="apellido" required />
						</div>
					</div>			
					<div class="form-group">
						<label for="email" class="control-label col-md-2">E-mail:</label>
						<div class="col-md-7">
							<input type="email" class="form-control" id="email" required />
						</div>
					</div>			
					<div class="form-group">
						<label for="mensaje" class="control-label col-md-2">Mensaje:</label>
						<div class="col-md-7">
							<textarea class="form-control" id="mensaje" required></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-7 col-md-offset-2">
							<div id="divMsjContacto" class="divMsj alert alert-danger" role="alert">
								<span id="txtHint"></span>
							</div>
						</div>
					</div>
					<div class="form-group" id="divBotones">
						<div class="col-md-9 txtRight">
							<button type="submit" class="btn btn-danger">Enviar</button>
						</div>
					</div>			
				</form>
				 -->
			</div>
			<div class="col-md-4">
				<img alt="" src="img/contacto.jpg" style="width: 100%; height: auto;" />
			</div>
		</div>
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>