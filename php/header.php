<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39486172-6', 'auto');
  ga('send', 'pageview');

</script>
<div class="header">
	<?php if (!isset($_SESSION['is_logged_in'])){ ?>
		<span class="clickable" data-toggle="modal" data-target="#login-dialog">ACCEDER</span>
		<span class="clickable sinDesktop sinMovil" data-toggle="modal" data-target="#registro-form" style="margin-left: 10px; color: red;">REGISTRARSE</span>
	<?php } else { ?>
		<button class="btn btn-default btn-xs" onclick="location.href='admin';" title="Administrar"><i class="fa fa-wrench fa-fw"></i></button>
		<span><?php echo $_SESSION["NombUsua"];?> <button class="btn btn-default btn-xs" title="Salir" onclick="location.href='php/logout.php';"><i class="fa fa-sign-out fa-fw"></i></button></span> 
	<?php } ?> 
</div>
<nav class="navbar navbar-default">
	<div class="container-fluid">
    	<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
    		<a class="navbar-brand" href="<?php echo $raiz;?>"><img alt="Logo" src="img/logo2.png" style="width: 210px; height: auto;" /></a>
		</div>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="nav navbar-nav navbar-center">
				<li><a id="quienes" href="quienes-somos.php">Quienes Somos</a></li>
				<li><a id="caracteristicas" href="caracteristicas.php">Caracter&iacute;sticas</a></li>
				<li><a id="fabricas" href="#"> F&aacute;bricas <span class="caret"></span></a></li>
				<li><a id="ofertas" href="ofertas.php">Ofertas</a></li>
				<li><a id="premium" href="premium.php">Premium</a></li>
				<li><a id="mayorista" href="mayorista.php">Mayorista</a></li>
				<li><a id="financiacion" href="financiacion100.php">Financiaci&oacute;n 100%</a></li>
				<li><a id="blog" href="blog.php">Blog</a></li>
				<li><a id="contacto" href="contacto.php">Contacto</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<form id="search-form" class="navbar-form navbar-left" role="search" action="resultados.php" method="post">
					<div class="form-group">
						<input id="search-text" name="search-text" type="text" class="form-control" placeholder="Buscar" value="<?php if (isset($_GET["termino"])) echo $_GET["termino"];?>" />
					</div>
					<button type="submit" class="btn btn-default" style="display: none;">Buscar</button>
				</form>				
			</ul>
		</div>
	</div>
</nav>
<div id="menuFabricas">
	<div id="cerrarMenu" class="sinDesktop fixed top right"><i class="fa fa-times fa-2x"></i></div>
<?php
	$tabla = cargarTabla("SELECT NumeFabr, NombFabr, Logo, Menu, Dominio FROM fabricas WHERE Estado = 1");
	$strSalida = "";
	if ($tabla->num_rows < 4) {
		$width = "20";
	}
	else {
		$width = (100 / $tabla->num_rows) - (2);
	}
		
	while ($fila = $tabla->fetch_array()) {
		$strSalida.= $crlf.'<div class="menuFabrica" style="width: '. $width .'%;">';
		$strSalida.= $crlf.'<a href="fabrica/'. $fila["Dominio"] .'/" title="'. $fila["NombFabr"] .'">';
		$strSalida.= $crlf.'<div class="imgFabrica" style="background: url(\'admin/'. $fila["Menu"] . '\') center/cover no-repeat;"></div>';
		$strSalida.= $crlf.'<br>';
		$strSalida.= $crlf.'<img src="admin/'. $fila["Logo"] . '" style="width: 100%; height: auto;" />';
		$strSalida.= $crlf.'</a>';
		$strSalida.= $crlf.'</div>';
	}
		
	echo $strSalida;
	
	if (isset($tabla))
		$tabla->free();
?>
</div>

<div class="modal fade" id="login-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Acceder</h4>
			</div>
			<form id="login-form" class="form-horizontal" method="post" data-dialog="#login-dialog">
				<input type="hidden" id="returnUrl" value="-1" /> 
				<div class="modal-body">
					<div class="form-group">
						<label for="usuario" class="control-label col-md-4">Usuario:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="usuario" placeholder="Usuario" required />
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-md-4">Contrase&ntilde;a:</label>
						<div class="col-md-8">
							<input type="password" class="form-control" id="password" placeholder="Contrase&ntilde;a" required />
						</div>
					</div>
					<div id="divMsjLogin" class="divMsj alert alert-danger" role="alert">
						<span id="txtHint">Info</span>
					</div>
				</div>
				<div class="modal-footer" id="divBotones">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Acceder</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="share-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalShare">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalShare">Compartinos en tus redes sociales</h4>
			</div>
			<div class="modal-body">
				<img src="<?php echo $raiz?>img/redes/facebook.png" class="sharer clickable" style="width:50px; height:auto;" alt="Facebook" data-sharer="facebook" data-title="Ofertas de Fábrica!" data-url="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
				<img src="<?php echo $raiz?>img/redes/twitter.png" class="sharer clickable" style="width:50px; height:auto;" alt="Twitter" data-sharer="twitter" data-title="Ofertas de Fábrica!" data-url="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
				<img src="<?php echo $raiz?>img/redes/google.png" class="sharer clickable" style="width:50px; height:auto;" alt="Google +" data-sharer="googleplus" data-title="Ofertas de Fábrica!" data-url="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
				<img src="<?php echo $raiz?>img/redes/pinterest.png" class="sharer clickable" style="width:50px; height:auto;" alt="Pinterest" data-sharer="pinterest" data-title="Ofertas de Fábrica!" data-url="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
				<img src="<?php echo $raiz?>img/redes/linkedin.png" class="sharer clickable" style="width:50px; height:auto;" alt="LinkedIn" data-sharer="linkedin" data-title="Ofertas de Fábrica!" data-url="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
			</div>
		</div>
	</div>
</div>