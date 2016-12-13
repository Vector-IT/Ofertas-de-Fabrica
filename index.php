<?php 
	ini_set("log_errors", 1);
	ini_set("error_log", "php-error.log");

	session_start();
	include_once 'admin/php/conexion.php';
	include 'revslider-standalone/embed.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica</title>
	
	<?php include_once 'php/linksHead.php';?>

	<link href="<?php echo $raiz;?>css/index.css" rel="stylesheet" type="text/css">
	
	<?php RevSliderEmbedder::headIncludes(); ?>
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<?php RevSliderEmbedder::putRevSlider('Inicio'); ?>
	 
	<div class="row">
		<div class="col-md-8 col-md-offset-2 txtCenter">
			<span class="cajaRoja clickable" data-js="scrolar('#rowOfertas');">Ver Ofertas</span>
		</div>
	</div>
	
	<?php include_once 'php/formBusqueda.php';?>
	
	<div class="home-titulo">
		<h1 class="txtTitulo">Ofertas de F&aacute;brica</h1>
		<div class="txtDescr">
			El sitio donde podr&aacute;s encontrar las mejores ofertas y 
			descuentos especiales de diferentes empresas desarrollistas de viviendas
		</div>
	</div>
	<div class="fabricas">
		<?php
			$tabla = cargarTabla("SELECT NumeFabr, Logo, NombFabr, Dominio FROM fabricas where Estado = 1");
			$strSalida = "";
			
			while ($fila = $tabla->fetch_array()) {
				$strSalida.= $crlf.'<span class="fabrica">';
				$strSalida.= $crlf.'<a href="fabrica/'. $fila["Dominio"] .'" title="'. $fila["NombFabr"] .'">';
				$strSalida.= '<img src="admin/'. $fila["Logo"] . '" />';
				$strSalida.= '</a>';
				$strSalida.= $crlf.'</span>';
			}
				
			echo $strSalida;
			
			if (isset($tabla))
				$tabla->free();
		?>
	</div>

	<div class="row" id="rowOfertas">
		<img alt="Logo" src="img/ofertas_logo.png" style="width: 210px; height: auto;" />
	</div>
	<?php
		$strSalida = "";
		
		$strSQL = "SELECT t.NumeTipo, t.NombTipo, t.Imagen, t.Precio,";
		$strSQL.= " f.NombFabr, f.Logo, f.Dominio";
		$strSQL.= " FROM tipologias t";
		$strSQL.= " INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
		$strSQL.= " WHERE t.Oferta = 1";
		$strSQL.= " AND f.Estado = 1";
		$strSQL.= " ORDER BY f.NumeFabr, t.NombTipo";
		
		$tipologias = cargarTabla($strSQL);

		$I = 1;
		
		$strSalida.= '<div class="row divTipologias">';
		while ($fila = $tipologias->fetch_array()) {
			if ($I == 6) {
				$strSalida.= $crlf.'</div>';
				$strSalida.= '<div class="row divTipologias">';
				$I = 1;
			}
			
			if ($I == 1)
				$strSalida.= $crlf.'<div class="col-md-2 col-md-offset-1 marginTop40 txtCenter">';
			else
				$strSalida.= $crlf.'<div class="col-md-2 marginTop40 txtCenter">';
			
			$strSalida.= $crlf.'<div class="text-left">';
			$strSalida.= $crlf.'<a href="fabrica/'. $fila["Dominio"] .'/" title="'. $fila["NombFabr"] .'">';
			$strSalida.= '<img src="admin/'. $fila["Logo"] . '" style="width: 90%; height: auto;" />';
			$strSalida.= $crlf.'</a>';
			$strSalida.= $crlf.'</div>';
			
			$strSalida.= $crlf.'<div class="imgTipologia clickable" data-url="fabrica/'. $fila["Dominio"] . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'/" style="background: url(\'admin/'. $fila["Imagen"] . '\') center center/cover no-repeat;"></div>';
			$strSalida.= $crlf.'<br>';
			$strSalida.= $crlf.'<div class="cuadroNegro">';
			$strSalida.= $fila["NombTipo"];
			$strSalida.= '<br><span class="txtBold rojo">$ '. $fila["Precio"] . '</span>';
			$strSalida.= '</div>';
			$strSalida.= $crlf.'</div>';
			$I++;
		}
		$strSalida.= $crlf.'</div>';
			
		echo $strSalida;
		
		if (isset($tipologias))
			$tipologias->free();
	?>
	
	<div class="home-vivienda">
		<div class="row">
			<!-- 
			<div class="col-md-6">
				<p>
					<span class="cajaRoja">ACCED&Eacute; A TU VIVIENDA</span>
				</p>
				<br><br>
				<p class="text-justify">
					La técnica y la tecnología hacen ahora sus aportes a la industria de la construcción. 
					Así es más fácil diseñar y construir una obra de calidad como nunca antes. 
					Hoy es posible adquirir una casa moderna de estilo Contemporáneo hecha por medio de 
					construcción en seco, con paredes externas de fibrocemento e internas de roca de yeso, 
					con aislante termo-acústico y cielo raso de madera en una excelente combinación de buen 
					gusto y durabilidad.
				</p>
			</div>
			 -->
			<div class="col-md-10 col-md-offset-1">
				<form id="consulta-form" method="post" data-dialog="">
					<div class="row">
						<div class="col-md-6">
							<p>
								<span class="cajaRoja">ACCED&Eacute; A TU VIVIENDA</span>
							</p>
						</div>
					</div>
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
				<img src="img/telemarketer.png" alt="Telemarketer" />
				<br><br><br>
				<span class="cajaRoja">Respondemos tu consulta online</span>
				 -->
			</div>
			<div class="col-md-1">
			</div>
		</div>
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-4">
				<div class="fondoBlanco">
					<img src="img/proceso.jpg" alt="Proceso" style="width: 100%; height: auto;" />
					<br><br>
					<!--<h3>Proceso</h3>-->
					<p>
						Con el sistema de construcción en seco se obtiene una reducción del tiempo de obra que varía 
						entre 30% y 60% con respecto a la misma obra realizada en sistema tradicional.
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="fondoBlanco">
					<img src="img/fotos.jpg" alt="Fotos" style="width: 100%; height: auto;" />
					<br><br>
					<!--<h3>Fotos</h3>-->
					<p>
						Una solución rápida y económica, con virtudes que exceden las expectativas y responden a las 
						dudas o preocupaciones.
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="fondoBlanco">
					<img src="img/videos.jpg" alt="Videos" style="width: 100%; height: auto;" />
					<br><br>
					<!--<h3>Videos</h3>-->
					<p>
						Con más de de 3500 viviendas entregadas en todo el país y con la solides necesaria para 
						afrontar nuevos mercados.
					</p>
				</div>
			</div>
		</div>
		
		<div class="industrial">
			<div class="col-md-8 col-md-offset-2 txtCenter">
				<h1>Tu vivienda industrializada</h1>
				<div class="txtDescr">
					Creamos relaciones de confianza con nuestros  clientes, implementando innovadores sistemas 
					de financiación que se adecuen a las necesidades del mercado
				</div>
			</div>
			<div class="clearer"></div>
			<div class="row iconos fondoBlanco">
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/consultas.png" style="height: 100px; width: auto;"/><br><br>
					Consultas Online
				</div>
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/tipologias.png" style="height: 100px; width: auto;" /><br><br>
					Tipolog&iacute;as
				</div>
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/disena.png" style="height: 100px; width: auto;" /><br><br>
					Dise&ntilde;&aacute; tu vivienda
				</div>
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/tutoriales.png" style="height: 100px; width: auto;" /><br><br>
					Tutoriales
				</div>
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/ventajas.png" style="height: 100px; width: auto;" /><br><br>
					Ventajas
				</div>
				<div class="col-md-2 txtCenter">
					<img alt="" src="img/cotizar.png" style="height: 100px; width: auto;" /><br><br>
					Cotizar
				</div>
			</div>				
		</div>
	</div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>