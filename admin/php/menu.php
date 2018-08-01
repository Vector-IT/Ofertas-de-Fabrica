<?php include_once 'conexion.php';?>
<div id="sidebar" class="menu">
	<div class="absolute top5 right3">
		<button class="btnMenu btn btn-default btn-xs" title="Men&uacute;"><i class="fa fa-bars"></i></button>
	</div>
	<div class="item" data-url="index.php" title="Inicio">
		Inicio
		<div class="flRight"><i class="fa fa-home fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<?php if ($_SESSION['TipoUsua'] == "1") { ?>
	<div class="item" data-url="fabricas.php" title="F&aacute;bricas">
		F&aacute;bricas
		<div class="flRight"><i class="fa fa-industry fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<?php } ?>
	<div class="item" data-url="tipologias.php" title="Tipologias">
		Tipologias
		<div class="flRight"><i class="fa fa-modx fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<div class="item" data-url="cotizaciones.php" title="Cotizaciones">
		Cotizaciones
		<div class="flRight"><i class="fa fa-money fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<div class="item" data-url="blog.php" title="Blog">
		Blog
		<div class="flRight"><i class="fa fa-file-text fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<div class="item" data-url="/vehiculos/admin/" title="Vehículos">
		Vehículos
		<div class="flRight"><i class="fa fa-car fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<?php if ($_SESSION['TipoUsua'] == "1") { ?>
	<div class="item" data-url="usuarios.php" title="Usuarios">
		Usuarios
		<div class="flRight"><i class="fa fa-users fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<?php } ?>
	<div class="item" data-url="<?php echo $raiz;?>" title="Ir al Sitio">
		Ir al Sitio
		<div class="flRight"><i class="fa fa-paper-plane fa-fw"></i></div>
	</div>
	<div class="separator"></div>
	<div class="item" data-url="logout.php" title="Salir">
		Salir
		<div class="flRight"><i class="fa fa-sign-out fa-fw"></i></div>
	</div>
</div>

<button class="btnMenu onlyMobile btn btn-default btn-xs fixed top5 left5" title="Men&uacute;"><i class="fa fa-bars"></i></button>

<div class="jumbotron">
	<div class="container">
		<img alt="logo" src="img/logo2.png" style="width: 210px; height: auto;" >
	</div>
	<div class="absolute top5 right5">
		<small>
		<?php
			echo $_SESSION["NombUsua"];
		?>
		</small>
		<button class="btn btn-default btn-xs" onclick="location.href='logout.php';"><i class="fa fa-sign-out fa-fw"></i></button>
	</div>
</div>	
